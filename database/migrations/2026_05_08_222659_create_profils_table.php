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
            if (Schema::hasTable('profils')) {

                Log::warning('Migration profils ignorée : la table existe déjà.');

                return;
            }

            Schema::create('profils', function (Blueprint $table) {

                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        } catch (\Throwable $e) {

            Log::error('Erreur migration profils : ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
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

            // Vérifie si la table existe avant suppression
            if (!Schema::hasTable('profils')) {

                Log::warning('Rollback profils ignoré : table inexistante.');

                return;
            }

            Schema::dropIfExists('profils');

            Log::info('Rollback de la table profils effectué avec succès.');
        } catch (\Throwable $e) {

            Log::error('Erreur rollback profils : ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
};