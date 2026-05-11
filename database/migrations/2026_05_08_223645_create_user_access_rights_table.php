<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {

            // Vérifie si la table existe déjà
            if (Schema::hasTable('user_access_rights')) {

                Log::warning('Migration user_access_rights ignorée : la table existe déjà.');

                return;
            }

            Schema::create('user_access_rights', function (Blueprint $table) {

                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('access_right_id')->constrained('access_rights')->onDelete('cascade');
                $table->timestamps();

                // Empêche les doublons
                $table->unique(
                    ['user_id', 'access_right_id'],
                    'user_access_right_unique'
                );
            });

        } catch (\Throwable $e) {

            Log::error('Erreur migration user_access_rights : ' . $e->getMessage(), [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
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

            // Vérifie si la table existe
            if (!Schema::hasTable('user_access_rights')) {

                Log::warning('Rollback user_access_rights ignoré : table inexistante.');

                return;
            }

            Schema::dropIfExists('user_access_rights');

            Log::info('Rollback de la table user_access_rights effectué avec succès.');
        } catch (\Throwable $e) {

            Log::error('Erreur rollback user_access_rights : ' . $e->getMessage(), [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);

            throw $e;
        }
    }
};