<?php
// database/migrations/2026_04_21_000007_create_litiges_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('litiges', function (Blueprint $table) {
            $table->id('id_litige');
            $table->text('motif');
            $table->text('description')->nullable();
            $table->date('date_ouverture');
            $table->date('date_resolution')->nullable();
            $table->enum('statut', ['ouvert', 'en_cours', 'resolu', 'rejete'])->default('ouvert');
            $table->text('solution')->nullable();
            $table->foreignId('paiement_id')->constrained('paiements', 'id_paiement')->onDelete('cascade');
            $table->foreignId('traite_par')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('litiges');
    }
};