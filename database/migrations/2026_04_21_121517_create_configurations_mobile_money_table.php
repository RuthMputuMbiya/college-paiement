<?php
// database/migrations/2026_04_21_000010_create_configurations_mobile_money_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configurations_mobile_money', function (Blueprint $table) {
            $table->id('id_config');
            $table->string('operateur', 30);
            $table->string('nom_api', 50);
            $table->string('url_simulation', 255);
            $table->enum('statut', ['actif', 'inactif'])->default('actif');
            $table->json('parametres')->nullable();
            $table->integer('delai_simulation_ms')->default(2000);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configurations_mobile_money');
    }
};