<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profil;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // Récupération des profils
            $superAdminProfil = Profil::where('name', 'Super Admin')->first();

            if (!$superAdminProfil) {
                throw new Exception("Le profil 'Super Admin' n'existe pas. Exécute d'abord ProfilSeeder.");
            }

            $users = [
                [
                    'name' => 'Super Admin',
                    'email' => 'superadmin@example.com',
                    'password' => 'password123',
                    'profil_id' => $superAdminProfil->id,
                ],
            ];

            foreach ($users as $user) {
                User::firstOrCreate(
                    ['email' => $user['email']],
                    [
                        'name' => $user['name'],
                        'password' => Hash::make($user['password']),
                        'profil_id' => $user['profil_id'],
                    ]
                );
            }

        } catch (Exception $e) {
            Log::error('Erreur lors du UserSeeder', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}