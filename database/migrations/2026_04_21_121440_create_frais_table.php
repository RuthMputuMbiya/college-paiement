<?php
// database/migrations/2026_04_21_000005_create_frais_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('frais', function (Blueprint $table) {
            $table->id('id_frais');
            $table->string('libelle', 100);
            $table->text('description')->nullable();
            $table->decimal('montant', 12, 0);
            $table->decimal('penalite', 12, 0)->default(0);
            $table->date('date_echeance');
            $table->enum('periodicite', ['mensuel', 'trimestriel', 'semestriel', 'annuel'])->default('annuel');
            $table->enum('statut', ['actif', 'inactif'])->default('actif');
            $table->foreignId('classe_id')->constrained('classes', 'id_classe')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('frais');
    }
};