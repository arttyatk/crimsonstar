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
        Schema::create('user_token', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('token');
            $table->timestamp('valido_ate');
            $table->timestamps();

         
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

   
    public function down(): void
    {
        Schema::table('user_token', function (Blueprint $table) {
       
        $table->dropForeign(['user_id']);
    });
   
        Schema::dropIfExists('user_token');
    }
};