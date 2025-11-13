<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllProfileFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Campos da aba 'Informações'
           // $table->string('username')->unique()->after('email'); // Nome de usuário deve ser único
            $table->text('bio')->nullable();
            
            // Colunas para Imagens de Perfil e Capa (baseado no HTML)
            $table->string('avatarpf')->nullable(); // Imagem de Perfil
            $table->string('coverp')->nullable()->after('avatarpf'); // Imagem de Capa
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'bio',
                'avatarpf',
                'coverp',
            ]);
        });
    }
}