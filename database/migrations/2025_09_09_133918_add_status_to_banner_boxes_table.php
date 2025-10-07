<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('banner_boxes', function (Blueprint $table) {
            // Adiciona a coluna 'status' com um valor padrão 'ativo'
            $table->enum('status', ['ativo', 'inativo'])->default('ativo')->after('preco');
        });
    }

    public function down(): void
    {
        Schema::table('banner_boxes', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
