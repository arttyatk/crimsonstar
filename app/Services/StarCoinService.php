<?php

namespace App\Services;

use App\Models\User;
use App\Models\Inventario;
use Illuminate\Support\Facades\DB;

class StarCoinService
{
    /**
     * Mapeamento de Star Coins geradas por raridade.
     * Estes valores podem ser ajustados conforme o balanceamento do jogo.
     */
    const RARITY_COIN_MAP = [
        'comum'     => 1,
        'incomum'   => 3,
        'raro'      => 10,
        'epico'     => 50,
        'legendario'=> 250,
    ];

    /**
     * Retorna a quantidade de Star Coins a ser gerada com base na raridade.
     * @param string $raridade A raridade da carta (ex: 'comum', 'legendario').
     * @return int
     */
    public function getCoinsByRarity(string $raridade): int
    {
        return self::RARITY_COIN_MAP[$raridade] ?? 0;
    }

    /**
     * Adiciona Star Coins ao saldo de um usuário de forma segura (transação atômica).
     * @param User $user O modelo do usuário.
     * @param int $amount A quantidade de Star Coins a adicionar.
     * @return bool
     */
    public function addCoins(User $user, int $amount): bool
    {
        if ($amount <= 0) return false;

        // DB::transaction garante que a operação é atômica e segura.
        try {
            DB::transaction(function () use ($user, $amount) {
                // Previne condições de corrida ao usar 'increment'
                $user->increment('star_coins', $amount);
            });
            return true;
        } catch (\Exception $e) {
            // Log do erro (opcional)
            \Log::error("Erro ao adicionar Star Coins para o usuário {$user->id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove Star Coins do saldo de um usuário de forma segura.
     * @param User $user O modelo do usuário.
     * @param int $amount A quantidade de Star Coins a remover.
     * @return bool Retorna true se a remoção for bem-sucedida, false se o saldo for insuficiente.
     */
    public function removeCoins(User $user, int $amount): bool
    {
        if ($amount <= 0) return false;
        
        // Verifica o saldo antes da transação
        if ($user->star_coins < $amount) {
            return false; // Saldo insuficiente
        }

        try {
            DB::transaction(function () use ($user, $amount) {
                // Previne condições de corrida ao usar 'decrement'
                $user->decrement('star_coins', $amount);
            });
            return true;
        } catch (\Exception $e) {
            \Log::error("Erro ao remover Star Coins para o usuário {$user->id}: " . $e->getMessage());
            return false;
        }
    }
}