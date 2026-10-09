<?php
// database/migrations/2026_04_21_000008_create_recus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recus', function (Blueprint $table) {
            $table->id('id_recu');
            $table->string('numero_recu', 50)->unique();
            $table->string('chemin_fichier', 255);
            $table->date('date_generation');
            $table->foreignId('paiement_id')->constrained('paiements', 'id_paiement')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recus');
    }
};