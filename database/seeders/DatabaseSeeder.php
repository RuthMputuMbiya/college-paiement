<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $this->call([
            // ========== 1. CONFIGURATIONS DE BASE ==========
            RoleSeeder::class,                    // Gestion des rôles (via champ 'role' dans users)
            MobileMoneyConfigSeeder::class,       // Configuration Airtel, Orange, M-Pesa
            
            // ========== 2. UTILISATEURS ==========
            UserSeeder::class,                    // Admins et comptables (parents s'inscrivent eux-mêmes)
            
        ]);
    }
}