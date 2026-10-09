<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_devise_to_frais_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('frais', function (Blueprint $table) {
            $table->enum('devise', ['FC', 'USD'])->default('FC')->after('montant');
        });
    }

    public function down()
    {
        Schema::table('frais', function (Blueprint $table) {
            $table->dropColumn('devise');
        });
    }
};