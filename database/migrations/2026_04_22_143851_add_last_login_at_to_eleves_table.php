<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_last_login_at_to_eleves_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('eleves', function (Blueprint $table) {
            if (!Schema::hasColumn('eleves', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('premiere_connexion');
            }
        });
    }

    public function down()
    {
        Schema::table('eleves', function (Blueprint $table) {
            if (Schema::hasColumn('eleves', 'last_login_at')) {
                $table->dropColumn('last_login_at');
            }
        });
    }
};