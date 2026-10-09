<?php
// database/migrations/2026_04_21_000006_create_paiements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('id_paiement');
            $table->string('reference', 100)->unique();
            $table->decimal('montant', 12, 0);
            $table->date('date_paiement');
            $table->enum('statut', ['en_attente', 'valide', 'echoue', 'rembourse'])->default('en_attente');
            $table->string('operateur', 30);
            $table->string('numero_mobile', 20);
            $table->string('code_transaction', 100)->nullable();
            $table->text('reponse_api')->nullable();
            $table->foreignId('eleve_id')->constrained('eleves', 'id_eleve')->onDelete('cascade');
            $table->foreignId('frais_id')->constrained('frais', 'id_frais')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};