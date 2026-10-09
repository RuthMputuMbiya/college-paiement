<?php
// database/migrations/2026_04_21_000002_add_role_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['administrateur', 'comptable', 'parent'])->default('parent')->after('email');
            $table->string('telephone', 20)->nullable()->after('role');
            $table->string('adresse')->nullable()->after('telephone');
            $table->enum('statut', ['actif', 'inactif'])->default('actif')->after('adresse');
            $table->string('profession')->nullable()->after('statut');
            $table->string('identifiant_unique')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'telephone', 'adresse', 'statut', 'profession', 'identifiant_unique']);
        });
    }
};