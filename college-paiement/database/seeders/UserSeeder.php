<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    private function generateIdentifiant(string $role): string
    {
        $prefix = match($role) {
            'gestionnaire_systeme' => 'GS',
            'comptable' => 'CPT',
            'parent' => 'PAR',
            default => 'USR',
        };
        
        $date = now()->format('Y-m-d');
        $unique = strtoupper(Str::random(5));
        
        return "{$prefix}-{$date}-{$unique}";
    }

    public function run(): void
    {
        $this->command->line('═══════════════════════════════════════════════════');
        $this->command->info('🚀 CRÉATION DES GESTIONNAIRES SYSTÈME ET COMPTABLES');
        $this->command->line('═══════════════════════════════════════════════════');

        // ==================== 1. GESTIONNAIRES SYSTÈME ====================
        $this->command->info("\n📌 Création des gestionnaires système...");

        $gestionnaires = [
            [
                'name'      => 'Gemima',
                'email'     => 'gemima@gmail.com',
                'telephone' => '+243850612009',
                'role'      => 'gestionnaire_systeme'
            ],
            [
                'name'      => 'Ruth',
                'email'     => 'ruthmputu13@gmail.com',
                'telephone' => '+243997185648',
                'role'      => 'gestionnaire_systeme'
            ],
            [
                'name'      => 'Gestionnaire Système',
                'email'     => 'gestionnaire@college-ndg.cd',
                'telephone' => '+243811111111',
                'role'      => 'gestionnaire_systeme'
            ],
        ];

        foreach ($gestionnaires as $gestionnaire) {
            $identifiant = $this->generateIdentifiant('gestionnaire_systeme');
            
            DB::table('users')->updateOrInsert(
                ['email' => $gestionnaire['email']],
                [
                    'identifiant_unique' => $identifiant,
                    'name'               => $gestionnaire['name'],
                    'email'              => $gestionnaire['email'],
                    'telephone'          => $gestionnaire['telephone'],
                    'role'               => $gestionnaire['role'],
                    'password'           => Hash::make('password'),
                    'statut'             => 'actif',
                    'email_verified_at'  => now(),
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]
            );
            
            $this->command->info("   ✅ {$gestionnaire['name']} - {$gestionnaire['email']} (ID: {$identifiant})");
        }

        // ==================== 2. COMPTABLES ====================
        $this->command->info("\n📌 Création des comptables...");

        $comptables = [
            [
                'name'      => 'Daniel',
                'email'     => 'daniel.comptable@college-ndg.cd',
                'telephone' => '+243976387913',
                'role'      => 'comptable'
            ],
            [
                'name'      => 'Marie Comptable',
                'email'     => 'marie.comptable@college-ndg.cd',
                'telephone' => '+243833333333',
                'role'      => 'comptable'
            ],
        ];

        foreach ($comptables as $comptable) {
            $identifiant = $this->generateIdentifiant('comptable');
            
            DB::table('users')->updateOrInsert(
                ['email' => $comptable['email']],
                [
                    'identifiant_unique' => $identifiant,
                    'name'               => $comptable['name'],
                    'email'              => $comptable['email'],
                    'telephone'          => $comptable['telephone'],
                    'role'               => $comptable['role'],
                    'password'           => Hash::make('password'),
                    'statut'             => 'actif',
                    'email_verified_at'  => now(),
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]
            );
            
            $this->command->info("   ✅ {$comptable['name']} - {$comptable['email']} (ID: {$identifiant})");
        }

        $this->command->line("\n═══════════════════════════════════════════════════");
        $this->command->info("📊 RÉCAPITULATIF DES COMPTES CRÉÉS");
        $this->command->line("");

        $this->command->table(
            ['Nom', 'Email', 'Rôle', 'Mot de passe'],
            [
                ['Gemima', 'gemima@gmail.com', 'Gestionnaire Système', 'password'],
                ['Ruth', 'ruthmputu13@gmail.com', 'Gestionnaire Système', 'password'],
                ['Gestionnaire Système', 'gestionnaire@college-ndg.cd', 'Gestionnaire Système', 'password'],
                ['Daniel', 'daniel.comptable@college-ndg.cd', 'Comptable', 'password'],
                ['Marie', 'marie.comptable@college-ndg.cd', 'Comptable', 'password'],
            ]
        );

        $this->command->line("\n✅ Tous les comptes ont été créés !");
        $this->command->info("🔐 Identifiant de connexion : email / password");
        $this->command->line("═══════════════════════════════════════════════════");
    }
}