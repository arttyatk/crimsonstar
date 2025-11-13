<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\BannerBox;
use App\Models\GachaItem;
use App\Http\Controllers\GachaItemController;
use App\Http\Controllers\BannerBoxController;
use App\Models\Inventario;
use Illuminate\Support\Facades\Auth;
use App\Services\StarCoinService; // Importação do Serviço de Moedas

class GachaController extends Controller
{
    protected $starCoinService;
    
    // Custo de um pull. Ajuste este valor conforme o balanceamento do seu jogo.
    const GACHA_PULL_COST = 50; 

    // Injetamos o StarCoinService no construtor
    public function __construct(StarCoinService $starCoinService)
    {
        $this->starCoinService = $starCoinService;
    }

    public function spin(Request $request, $bannerId)
    {
        $user = Auth::user(); 
        
        // 1. VERIFICAR CUSTO E DEDUZIR MOEDAS
        if (!$this->starCoinService->removeCoins($user, self::GACHA_PULL_COST)) {
            // Se o saldo for insuficiente, retorna erro.
            return response()->json([
                'message' => 'Saldo insuficiente de Star Coins. Custo: ' . self::GACHA_PULL_COST,
                'current_coins' => $user->star_coins // Retorna o saldo atual para o front-end
            ], 403);
        }

        $banner = BannerBox::with('exclusivos')->findOrFail($bannerId);
        $todosExclusivos = $banner->exclusivos;

        // 2. FILTRAGEM CRÍTICA: Manter apenas itens do tipo 'item' para o sorteio.
        $items = $todosExclusivos->filter(function ($exclusivo) {
            return $exclusivo->tipo && strtolower($exclusivo->tipo) === 'item';
        });

        if ($items->isEmpty()) {
            // Se não houver itens, reembolsa o custo e retorna erro.
            $this->starCoinService->addCoins($user, self::GACHA_PULL_COST);
            return response()->json(['message' => 'Nenhum item do tipo "item" disponível para sorteio nesse banner.'], 400);
        }

        $pool = []; 

        // 3. Monta a "roleta" (pool) APENAS com os itens filtrados
        foreach ($items as $item) {
            $dropRate = $item->pivot->taxa_drop ?? 0; 
            
            for ($i = 0; $i < $dropRate; $i++) {
                $pool[] = $item;
            }
        }

        if (empty($pool)) {
            // Se não houver chance de drop, reembolsa o custo e retorna erro.
            $this->starCoinService->addCoins($user, self::GACHA_PULL_COST);
            return response()->json(['message' => 'Os itens disponíveis não possuem taxa de drop configurada (taxa_drop = 0 para todos).'], 400);
        }

        // 4. Sorteia o item (Será sempre um item do tipo 'item')
        $sorteado = $pool[array_rand($pool)]; 

        // 5. Salva no inventário do usuário
        $inventario = Inventario::firstOrCreate(
            ['user_id' => $user->id, 'gacha_item_id' => $sorteado->id],
            ['quantidade' => 0]
        );
        $inventario->increment('quantidade');

        // 6. GERAÇÃO DE MOEDAS: Calcula e adiciona Star Coins com base na raridade
        $coinsGenerated = $this->starCoinService->getCoinsByRarity($sorteado->raridade);
        
        if ($coinsGenerated > 0) {
            $this->starCoinService->addCoins($user, $coinsGenerated);
        }

        // 7. Prepara a resposta
        $user->refresh(); // Recarrega o usuário para pegar o saldo atualizado

        $originalItemIds = $items->pluck('id')->toArray();
        $winnerIndex = array_search($sorteado->id, $originalItemIds);
        
        if ($winnerIndex === false) {
             $winnerIndex = 0; 
        }

        return response()->json([
            'message' => 'Você obteve: ' . $sorteado->nome,
            'item' => $sorteado,
            'winnerIndex' => $winnerIndex,
            'inventario' => $inventario,
            'moedas_geradas' => $coinsGenerated,
            'novo_saldo_star_coins' => $user->star_coins // Saldo atualizado para o front-end
        ]);
    }

    public function show($userId)
    {
        $authUser = Auth::user();
        
        // Verificação de segurança
        if (!$authUser || $authUser->id != $userId) {
            return response()->json([
                'message' => 'Não autorizado ou ID de usuário inválido.'
            ], 403);
        }
        
        // Busca o inventário e o saldo do usuário
        $inventario = Inventario::where('user_id', $userId)
            ->where('quantidade', '>', 0)
            ->with('item') // Carrega o relacionamento completo com GachaItem
            ->get();

        $response = $inventario->map(function ($inventarioItem) {
            
            if (!$inventarioItem->item) {
                return null; 
            }
            
            return [
                'gacha_item_id' => $inventarioItem->gacha_item_id,
                'quantidade' => $inventarioItem->quantidade,
                // O front-end espera o objeto do item sob a chave 'item_info'
                'item_info' => [
                    'id' => $inventarioItem->item->id,
                    'nome' => $inventarioItem->item->nome,
                    'imagem_url' => $inventarioItem->item->imagem_url, // Usa o accessor do model
                    'raridade' => $inventarioItem->item->raridade,
                    'tipo' => $inventarioItem->item->tipo,
                    // ADICIONANDO AS INFORMAÇÕES QUE ESTAVAM FALTANDO:
                    'habilidades' => $inventarioItem->item->habilidades ?? [],
                    'passivas' => $inventarioItem->item->passivas ?? [],
                    'descricao' => $inventarioItem->item->descricao ?? null,
                ]
            ];
        })->filter();

        // Adiciona o saldo de Star Coins do usuário à resposta
        $user = $authUser->fresh(); // Garante que estamos pegando o saldo mais atualizado

        return response()->json([
            'inventario' => $response,
            'user_info' => [
                'star_coins' => $user->star_coins ?? 0 // Adiciona o saldo de moedas
            ]
        ]);
    }
}