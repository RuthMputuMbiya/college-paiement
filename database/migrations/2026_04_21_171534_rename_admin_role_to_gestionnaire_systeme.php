<?php
// database/migrations/2026_04_21_000000_rename_admin_role_to_gestionnaire_systeme.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Mettre à jour les valeurs enum dans la table users
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('gestionnaire_systeme', 'comptable', 'parent') NOT NULL DEFAULT 'parent'");
        
        // Mettre à jour les utilisateurs existants
        DB::table('users')
            ->where('role', 'administrateur')
            ->update(['role' => 'gestionnaire_systeme']);
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('administrateur', 'comptable', 'parent') NOT NULL DEFAULT 'parent'");
        
        DB::table('users')
            ->where('role', 'gestionnaire_systeme')
            ->update(['role' => 'administrateur']);
    }
};