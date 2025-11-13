<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('table_gacha_items', function (Blueprint $table) {
            // Adiciona a coluna para a recompensa de Star Coins, padrão 0 (zero)
            $table->unsignedInteger('star_coin_reward')
                  ->default(0)
                  ->after('raridade') // Posição lógica, ajuste se necessário
                  ->comment('Quantidade de Star Coins que a carta recompensa o usuário');
        });
    }

    public function down(): void
    {
        Schema::table('table_gacha_items', function (Blueprint $table) {
            $table->dropColumn('star_coin_reward');
        });
    }
};
