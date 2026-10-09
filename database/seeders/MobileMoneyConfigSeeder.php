<?php
// database/seeders/MobileMoneyConfigSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MobileMoneyConfigSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('configurations_mobile_money')->truncate();
        Schema::enableForeignKeyConstraints();

        $configs = [
            [
                'operateur' => 'airtel',
                'nom_api' => 'Airtel Money',
                'url_simulation' => '/api/simulate/airtel',
                'statut' => 'actif',
                'parametres' => json_encode([
                    'taux_succes' => 95,
                    'temps_attente' => 2000,
                    'code_succes' => '00'
                ]),
                'delai_simulation_ms' => 2000,
            ],
            [
                'operateur' => 'orange',
                'nom_api' => 'Orange Money',
                'url_simulation' => '/api/simulate/orange',
                'statut' => 'actif',
                'parametres' => json_encode([
                    'taux_succes' => 98,
                    'temps_attente' => 1500,
                    'code_succes' => '0000'
                ]),
                'delai_simulation_ms' => 1500,
            ],
            [
                'operateur' => 'mpesa',
                'nom_api' => 'M-Pesa',
                'url_simulation' => '/api/simulate/mpesa',
                'statut' => 'actif',
                'parametres' => json_encode([
                    'taux_succes' => 92,
                    'temps_attente' => 2500,
                    'code_succes' => '0'
                ]),
                'delai_simulation_ms' => 2500,
            ],
        ];

        foreach ($configs as $config) {
            DB::table('configurations_mobile_money')->insert([
                'operateur' => $config['operateur'],
                'nom_api' => $config['nom_api'],
                'url_simulation' => $config['url_simulation'],
                'statut' => $config['statut'],
                'parametres' => $config['parametres'],
                'delai_simulation_ms' => $config['delai_simulation_ms'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Configurations Mobile Money créées avec succès !');
        $this->command->info('   - Airtel Money (actif)');
        $this->command->info('   - Orange Money (actif)');
        $this->command->info('   - M-Pesa (actif)');
    }
}