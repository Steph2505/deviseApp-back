<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\AccessRight;
use App\Models\Profil;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {

            return response()->json([
                'success' => true,
                'data' => $this->userRepository->getAll()
            ]);

        } catch (Exception $e) {

            Log::error('Erreur récupération utilisateurs', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur récupération utilisateurs'
            ], 500);
        }
    }

    public function create()
    {
        try {

            $access = AccessRight::get();
            $profils = Profil::get();

            $datas = [
                'access' => $access,
                'profils' => $profils
            ];

            return response()->json([
                'success' => true,
                'data' => $datas
            ]);

        } catch (Exception $e) {

            Log::error('Etape de création utilisateurs échoué', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Etape de création utilisateurs échoué'
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'profil_id' => ['required', 'exists:profils,id'],
                'access_rights' => ['nullable', 'array'],
                'access_rights.*' => ['exists:access_rights,id'],
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $this->userRepository->create(
                $validator->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur créé avec succès',
                'generated_password' => $user->generated_password,
                'data' => $user
            ], 201);

        } catch (Exception $e) {

            Log::error('Erreur création utilisateur', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur création utilisateur'
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {

            return response()->json([
                'success' => true,
                'data' => $this->userRepository->findById($id)
            ]);

        } catch (Exception $e) {

            Log::error('Erreur récupération utilisateur', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Utilisateur introuvable'
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email,' . $id],
                'profil_id' => ['required', 'exists:profils,id'],
                'access_rights' => ['nullable', 'array'],
                'access_rights.*' => ['exists:access_rights,id'],
            ]);
            
            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $this->userRepository->update(
                $id,
                $validator->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur mis à jour',
                'data' => $user
            ]);

        } catch (Exception $e) {

            Log::error('Erreur mise à jour utilisateur', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur mise à jour utilisateur'
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        try {

            $this->userRepository->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur supprimé'
            ]);

        } catch (Exception $e) {

            Log::error('Erreur suppression utilisateur', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur suppression utilisateur'
            ], 500);
        }
    }
}