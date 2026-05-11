<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {

            if (Schema::hasTable('devises')) {

                Log::warning('Migration devises ignorée : la table existe déjà.');

                return;
            }

            Schema::create('devises', function (Blueprint $table) {

                $table->id();
                $table->string('code', 3)->unique();
                $table->string('name');
                $table->string('symbol');
                $table->decimal('exchange_rate', 15, 6);
                $table->boolean('is_active')->default(true);
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
            });
        } catch (\Throwable $e) {

            Log::error('Erreur migration devises : ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }


    public function down(): void
    {
        try {

            // Vérifie si la table existe avant suppression
            if (!Schema::hasTable('devises')) {

                Log::warning('Rollback devises ignoré : table inexistante.');

                return;
            }

            Schema::dropIfExists('devises');

            Log::info('Rollback de la table devises effectué avec succès.');
        } catch (\Throwable $e) {

            Log::error('Erreur rollback devises : ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
};