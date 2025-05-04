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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('description');
            $table->enum('type', ['Papel', 'Pedra', 'Tesoura']);
            $table->enum('effect', ['Ataque', 'Defesa', 'Cura']);
            $table->integer('points');
            $table->enum('rarity', ['Comum', 'Raro', 'Lendário', 'Mítico']);
            $table->integer('cost');
            $table->string('link_img');
            $table->integer('percentage_drop');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card');
    }
};
