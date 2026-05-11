<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profil;
use Illuminate\Support\Facades\Log;
use Exception;

class ProfilSeeder extends Seeder
{
    public function run(): void
    {
        $profils = [
            [
                'name' => 'Super Admin',
                'description' => 'Accès total au système',
            ],
            [
                'name' => 'Admin',
                'description' => 'Accès administratif standard',
            ],
            [
                'name' => 'Consultant',
                'description' => 'Accès en consultation uniquement',
            ],
        ];

        try {
            foreach ($profils as $profil) {
                Profil::firstOrCreate(
                    ['name' => $profil['name']],
                    $profil
                );
            }
        } catch (Exception $e) {
            Log::error('Erreur lors de l exécution du ProfilSeeder', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }
}