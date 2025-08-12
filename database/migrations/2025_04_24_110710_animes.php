<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('titulo_alternativo')->nullable();
            $table->float('nota', 3, 1)->default(0);
            $table->integer('popularidade')->default(0);
            $table->string('generos');
            $table->string('autor')->nullable();
            $table->string('estudio')->nullable();
            $table->year('ano_lancamento')->nullable();
            $table->integer('episodios')->default(0);
            $table->integer('rank')->default(0);
            $table->string('cover_image')->nullable();
            $table->string('categoria_imagem')->nullable();
            $table->string('descricao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('animes');
    }
};