<?php
// database/migrations/xxxx_xx_xx_xxxxxx_update_date_echeance_in_frais_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Mettre à jour les enregistrements avec date_echeance null
        DB::table('frais')->whereNull('date_echeance')->update([
            'date_echeance' => now()->addMonths(6)->format('Y-m-d')
        ]);
    }

    public function down()
    {
        // Pas de rollback nécessaire
    }
};