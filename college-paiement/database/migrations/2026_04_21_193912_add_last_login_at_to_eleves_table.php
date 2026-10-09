<?php
// database/migrations/2026_04_21_000001_add_last_login_at_to_eleves_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Vérifier si la table existe avant d'ajouter la colonne
        if (Schema::hasTable('eleves')) {
            Schema::table('eleves', function (Blueprint $table) {
                if (!Schema::hasColumn('eleves', 'last_login_at')) {
                    $table->timestamp('last_login_at')->nullable()->after('premiere_connexion');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('eleves')) {
            Schema::table('eleves', function (Blueprint $table) {
                if (Schema::hasColumn('eleves', 'last_login_at')) {
                    $table->dropColumn('last_login_at');
                }
            });
        }
    }
};