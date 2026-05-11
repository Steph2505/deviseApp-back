<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Str;
use Exception;

class AuthRepository extends ResourceRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    private function validate(array $data, array $rules)
    {
        return Validator::make($data, $rules);
    }

    private function successResponse(string $message, $data = null, int $status = 200) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    //Erreur Json
    private function errorResponse(string $message,$error = null,int $status = 500) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error
        ], $status);
    }


    private function generateToken(User $user): array
    {
        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
        ];
    }

    public function login(Request $request)
    {
        try {

            $validator = $this->validate($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {

                return $this->errorResponse(
                    'Les données envoyées sont invalides.',
                    $validator->errors(),
                    422
                );
            }

            $user = $this->model->with('accessRights')
                ->where('email', $request->email)
                ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {

                Log::warning('Connexion échouée : identifiants invalides.', [
                    'email' => $request->email
                ]);

                return $this->errorResponse(
                    'Adresse email ou mot de passe incorrect.',
                    null,
                    401
                );
            }

            return $this->successResponse(
                'Connexion effectuée avec succès.',
                $this->generateToken($user)
            );

        } catch (Exception $e) {

            Log::error('Erreur connexion.', [
                'message' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Une erreur est survenue lors de la connexion.',
                $e->getMessage()
            );
        }
    }

    public function logout(Request $request)
    {
        try {

            $user = $request->user();

            if ($user) {

                $user->currentAccessToken()->delete();

                Log::info('Déconnexion réussie.', [
                    'user_id' => $user->id
                ]);
            }

            return $this->successResponse(
                'Déconnexion effectuée avec succès.'
            );

        } catch (Exception $e) {

            Log::error('Erreur déconnexion.', [
                'message' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Une erreur est survenue lors de la déconnexion.',
                $e->getMessage()
            );
        }
    }
}