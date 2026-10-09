<?php
// database/migrations/2026_04_21_000009_create_simulations_paiement_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('simulations_paiement', function (Blueprint $table) {
            $table->id('id_simulation');
            $table->json('requete');
            $table->json('reponse');
            $table->enum('statut', ['pending', 'success', 'failed'])->default('pending');
            $table->integer('temps_reponse_ms')->nullable();
            $table->foreignId('paiement_id')->constrained('paiements', 'id_paiement')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('simulations_paiement');
    }
};