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
            $table->string('username')->unique()->after('email'); // Nome de usuário deve ser único
            $table->string('phone')->nullable()->after('username');
            $table->date('birthdate')->nullable()->after('phone');
            $table->string('location')->nullable()->after('birthdate');
            $table->text('bio')->nullable()->after('location');

            // Campos da aba 'Redes Sociais'
            $table->string('discord')->nullable()->after('bio');
            $table->string('twitter')->nullable()->after('discord');
            $table->string('instagram')->nullable()->after('twitter');
            $table->string('tiktok')->nullable()->after('instagram'); // Mapeado de 'linkedin'
            $table->string('snapchat')->nullable()->after('tiktok'); // Mapeado de 'github'
            
            // Colunas para Imagens de Perfil e Capa (baseado no HTML)
            $table->string('avatarpf')->nullable()->after('snapchat'); // Imagem de Perfil
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
                'phone',
                'birthdate',
                'location',
                'bio',
                'discord',
                'twitter',
                'instagram',
                'tiktok',
                'snapchat',
                'avatarpf',
                'coverp',
            ]);
        });
    }
}