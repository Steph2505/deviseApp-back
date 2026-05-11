<?php

namespace App\Http\Controllers;

use App\Repositories\DeviseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class DevisController extends Controller
{
    protected $deviseRepository;

    public function __construct(DeviseRepository $deviseRepository)
    {
        $this->deviseRepository = $deviseRepository;
    }

    //Liste des devises
    public function index(Request $request)
    {
        try {

            $perPage = $request->get('per_page', 15);
            $devises = $this->deviseRepository->getPaginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $devises,
                'message' => 'Liste des devises récupérée avec succès'
            ]);

        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des devises : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des devises',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Store devise
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'code' => 'required|string|size:3|unique:devises,code',
                'name' => 'required|string|max:255',
                'symbol' => 'required|string|max:10',
                'exchange_rate' => 'required|numeric|min:0',
                'is_active' => 'boolean',
            ]);

            if ($validator->fails()) {
                Log::warning('Verification des données échouée', ['errors' => $validator->errors()]);

                return response()->json([
                    'success' => false,
                    'message' => 'Validation des données échouée',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $request['user_id'] = Auth()->id();
            $devise = $this->deviseRepository->store($request->all());

            return response()->json([
                'success' => true,
                'data' => $devise,
                'message' => 'Devise créée avec succès'
            ], 201);

        } catch (Exception $e) {
            Log::error('Erreur lors de la création de la devise : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la devise',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //detail devise
    public function show($id)
    {
        try {

            $devise = $this->deviseRepository->getById($id);

            if (!$devise) {
                Log::warning('Devise indisponible', ['id' => $id]);

                return response()->json([
                    'success' => false,
                    'message' => 'Devise indisponible'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $devise,
                'message' => 'Devise récupérée avec succès'
            ]);

        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération de la devise : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de la devise',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //update devise
    public function update(Request $request, $id)
    {
        try {

            $devise = $this->deviseRepository->getById($id);

            if (!$devise) {
                Log::warning('Devise non trouvée', ['id' => $id]);

                return response()->json([
                    'success' => false,
                    'message' => 'Devise non trouvée'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'code' => 'required|string|size:3|unique:devises,code,' . $id,
                'name' => 'required|string|max:255',
                'symbol' => 'required|string|max:10',
                'exchange_rate' => 'required|numeric|min:0',
                'is_active' => 'boolean',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation des données échouée', ['errors' => $validator->errors()]);

                return response()->json([
                    'success' => false,
                    'message' => 'Validation des données échouée',
                    'errors' => $validator->errors()
                ], 422);
            }
            $request['user_id'] = Auth()->id();
            $updatedDevise = $this->deviseRepository->update($id, $request->all());

            // $updatedDevise = $this->deviseRepository->getById($id);

            return response()->json([
                'success' => true,
                'data' => $updatedDevise,
                'message' => 'Devise mise à jour avec succès'
            ]);

        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour de la devise : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la devise',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //delete devise
    public function destroy($id)
    {
        try {

            $devise = $this->deviseRepository->getById($id);

            if (!$devise) {
                Log::warning('Devise non trouvée pour suppression', ['id' => $id]);

                return response()->json([
                    'success' => false,
                    'message' => 'Devise non trouvée'
                ], 404);
            }

            $this->deviseRepository->destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'Devise supprimée avec succès'
            ]);

        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression de la devise : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la devise',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
