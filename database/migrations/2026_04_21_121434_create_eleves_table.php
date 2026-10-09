<?php
// database/migrations/2026_04_21_000004_create_eleves_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id('id_eleve');
            $table->string('email', 100)->unique();
            $table->string('mot_de_passe');
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->date('date_naissance');
            $table->enum('sexe', ['M', 'F']);
            $table->string('telephone_parent', 20);
            $table->string('nom_parent', 100);
            $table->string('email_parent', 100);
            $table->foreignId('classe_id')->constrained('classes', 'id_classe')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->enum('statut', ['inscrit', 'exclu', 'transfere'])->default('inscrit');
            $table->boolean('premiere_connexion')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eleves');
    }
};