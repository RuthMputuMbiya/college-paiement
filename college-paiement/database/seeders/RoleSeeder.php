<?php
// database/seeders/RoleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('✅ Les rôles sont gérés via le champ "role" dans la table users');
        $this->command->info('   - administrateur');
        $this->command->info('   - comptable');
        $this->command->info('   - parent');
    }
}