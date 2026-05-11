<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {

            // Vérifier si la table users existe
            if (!Schema::hasTable('users')) {

                Log::warning('La table users est introuvable.');

                return;
            }

            if (Schema::hasColumn('users', 'profil_id')) {

                Log::warning('La colonne profil_id existe déjà dans users.');

                return;
            }

            Schema::table('users', function (Blueprint $table) {

                $table->foreignId('profil_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('profils')
                    ->onDelete('set null');

            });

        } catch (Exception $e) {

            Log::error('Erreur lors de la migration ajout profil_id.', [
                'message' => $e->getMessage(),
                'ligne' => $e->getLine(),
                'fichier' => $e->getFile(),
            ]);

            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            if (!Schema::hasTable('users')) {

                Log::warning('La table users est introuvable.');

                return;
            }

            // Vérifier si colonne profil_id existe
            if (!Schema::hasColumn('users', 'profil_id')) {

                Log::warning('La colonne profil_id n\'existe pas dans users.');

                return;
            }

            Schema::table('users', function (Blueprint $table) {

                $table->dropForeign(['profil_id']);
                $table->dropColumn('profil_id');

            });

        } catch (Exception $e) {

            Log::error('Erreur lors du rollback suppression profil_id.', [
                'message' => $e->getMessage(),
                'ligne' => $e->getLine(),
                'fichier' => $e->getFile(),
            ]);

            throw $e;
        }
    }
};