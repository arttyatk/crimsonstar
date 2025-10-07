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
        Schema::create('table_gacha_items', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('titulo')->nullable();
            $table->string('imagem')->nullable();
            $table->enum('tipo', ['personagem', 'item']);
            $table->enum('raridade', ['comum', 'incomum', 'raro', 'epico', 'legendario']);
            $table->text('descricao')->nullable();
            $table->json('passivas')->nullable();
            $table->json('habilidades')->nullable();
            $table->boolean('status')->default(true);
            $table->decimal('taxa_drop', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_gacha_items');
    }
};
