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

class GachaController extends Controller
{
    public function spin(Request $request, $bannerId)
    {
        $user = Auth::user(); 
        
        $banner = BannerBox::with('exclusivos')->findOrFail($bannerId);
        $todosExclusivos = $banner->exclusivos;

        // 1. FILTRAGEM CRÍTICA: Manter apenas itens do tipo 'item' para o sorteio.
        $items = $todosExclusivos->filter(function ($exclusivo) {
            return $exclusivo->tipo && strtolower($exclusivo->tipo) === 'item';
        });

        if ($items->isEmpty()) {
            // Se não houver itens do tipo 'item' no banner
            return response()->json(['message' => 'Nenhum item do tipo "item" disponível para sorteio nesse banner.'], 400);
        }

        $pool = []; 

        // 2. Monta a "roleta" (pool) APENAS com os itens filtrados
        foreach ($items as $item) {
            // Usa 0 como default se taxa_drop não estiver definida/for nula
            $dropRate = $item->pivot->taxa_drop ?? 0; 
            
            for ($i = 0; $i < $dropRate; $i++) {
                $pool[] = $item;
            }
        }

        if (empty($pool)) {
            return response()->json(['message' => 'Os itens disponíveis não possuem taxa de drop configurada (taxa_drop = 0 para todos).'], 400);
        }

        // 3. Sorteia o item (Será sempre um item do tipo 'item')
        $sorteado = $pool[array_rand($pool)]; 

        // 4. Salva no inventário do usuário
        // ... (lógica de salvamento)
        $inventario = Inventario::firstOrCreate(
            ['user_id' => $user->id, 'gacha_item_id' => $sorteado->id],
            ['quantidade' => 0]
        );
        $inventario->increment('quantidade');

        // 5. Busca o índice (O array $items é o mesmo que o front-end está usando)
        $originalItemIds = $items->pluck('id')->toArray();
        
        $winnerIndex = array_search($sorteado->id, $originalItemIds);
        
        if ($winnerIndex === false) {
             // Este fallback não deve mais ser necessário, mas mantemos por segurança.
             $winnerIndex = 0; 
        }

        return response()->json([
            'message' => 'Você obteve: ' . $sorteado->nome,
            'item'    => $sorteado,
            'winnerIndex' => $winnerIndex,
            'inventario' => $inventario
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
        
        // Busca o inventário usando ->with('item') e carrega o relacionamento completo
        $inventario = Inventario::where('user_id', $userId)
            ->where('quantidade', '>', 0)
            ->with('item') // Carrega o relacionamento completo com GachaItem
            ->get();

        // Mapeia a resposta para a estrutura esperada pelo front-end
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

        return response()->json($response);
    }
}