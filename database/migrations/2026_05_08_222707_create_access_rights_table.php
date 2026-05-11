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
            if (Schema::hasTable('access_rights')) {

                Log::warning('Migration access_rights ignorée : la table existe déjà.');

                return;
            }

            Schema::create('access_rights', function (Blueprint $table) {

                $table->id();
                $table->string('name'); 
                $table->string('description')->nullable();
                $table->timestamps();
            });

            Log::info('Migration access_rights exécutée avec succès.');
        } catch (\Throwable $e) {

            Log::error('Erreur migration access_rights : ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
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
            if (!Schema::hasTable('access_rights')) {

                Log::warning('Rollback access_rights ignoré : table inexistante.');

                return;
            }

            Schema::dropIfExists('access_rights');

            Log::info('Rollback de la table access_rights effectué avec succès.');
        } catch (\Throwable $e) {

            Log::error('Erreur rollback access_rights : ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
};