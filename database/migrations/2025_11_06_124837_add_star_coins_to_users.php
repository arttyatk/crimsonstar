<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adiciona a coluna 'star_coins' na tabela 'users' com valor inicial de 100.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Utilizamos 'unsignedBigInteger' para garantir que o valor seja grande e nunca negativo, 
            // e definimos o default como 100 Star Coins iniciais.
            $table->unsignedBigInteger('star_coins')->default(100)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     * Remove a coluna 'star_coins' caso seja necessário reverter a migração.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('star_coins');
        });
    }
};