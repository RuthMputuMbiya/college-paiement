<?php
// database/migrations/2026_04_21_000003_create_classes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id('id_classe');
            $table->string('nom_classe', 50);
            $table->string('niveau', 30);
            $table->string('annee_scolaire', 20);
            $table->integer('capacite')->default(40);
            $table->integer('effectif')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
};