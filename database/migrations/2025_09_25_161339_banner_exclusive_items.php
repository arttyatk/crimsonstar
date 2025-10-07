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
        Schema::create('banner_exclusive_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')
                  ->constrained('banner_boxes')
                  ->onDelete('cascade');
            $table->foreignId('item_id')
                  ->constrained('table_gacha_items')
                  ->onDelete('cascade');
            $table->boolean('is_exclusive')->default(true);
            $table->decimal('taxa_drop', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_exclusive_items');
    }
};
