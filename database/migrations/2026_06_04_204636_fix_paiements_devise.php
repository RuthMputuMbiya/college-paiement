<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixPaiementsDevise extends Migration
{
    public function up()
    {
        // Mettre à jour les paiements en attente avec montant rond
        DB::table('paiements')
            ->where('devise', 'USD')
            ->where('statut', 'en_attente')
            ->whereRaw('montant = FLOOR(montant)')
            ->update(['devise' => 'FC']);
        
        // Mettre à jour les anciens paiements
        DB::table('paiements')
            ->where('reference', 'like', 'PAY-%')
            ->where('devise', 'USD')
            ->update(['devise' => 'FC']);
    }

    public function down()
    {
        // Pas de rollback nécessaire
    }
}