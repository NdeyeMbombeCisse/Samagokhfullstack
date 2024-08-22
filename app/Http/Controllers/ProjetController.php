<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProjetRequest;
use App\Http\Requests\UpdateProjetRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewProjectNotification;

class ProjetController extends Controller
{
    // Uncomment and configure the middleware if needed
    // function __construct()
    // {
    //     $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:project-create', ['only' => ['store']]);
    //     $this->middleware('permission:project-edit', ['only' => ['update']]);
    //     $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Vérifier si l'utilisateur est connecté
        if ($user) {
            // Filtrer les projets par la commune de l'utilisateur connecté
            $projets = Projet::where('commune_id', $user->commune_id)->get();

            // Vérifier s'il n'y a aucun projet
            if ($projets->isEmpty()) {
                return response()->json(['message' => 'Aucun projet disponible pour votre commune.'], 200); // 200 OK
            }

            // return response()->json($projets, 200); // 200 OK
            return $this->Response('Liste des projets', $projets);
        }

        // Si l'utilisateur n'est pas connecté, retourner une réponse d'erreur
        return response()->json(['error' => 'Unauthorized'], 401); // 401 Unauthorized
    }



    /**
     * Store a newly created resource in storage.
     */

public function store(StoreProjetRequest $request): JsonResponse
{
    try {
        // Créez le projet avec l'utilisateur connecté comme créateur
        $projet = Projet::create(array_merge(
            $request->validated(),
            ['user_id' => Auth::id()] // Ajoutez l'utilisateur connecté
        ));

        // Envoyez une notification à tous les utilisateurs
        Notification::send(User::all(), new NewProjectNotification($projet));

        return response()->json($projet, 201); // 201 Created
    } catch (\Exception $e) {
        return response()->json(['error' => 'Unable to create project', 'message' => $e->getMessage()], 500); // 500 Internal Server Error
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Projet $projet): JsonResponse
    {
        return response()->json($projet, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjetRequest $request, Projet $projet): JsonResponse
    {
        $projet->update($request->validated());
        return response()->json($projet, 200); // 200 OK
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projet $projet): JsonResponse
    {
        $projet->delete();
        return response()->json(null, 204); // 204 No Content
    }
}
