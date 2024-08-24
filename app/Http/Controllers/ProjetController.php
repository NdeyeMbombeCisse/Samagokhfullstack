<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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
    // public function index(): JsonResponse
    // {
    //     // Récupérer l'utilisateur connecté
    //     $user = Auth::user();

    //     // Vérifier si l'utilisateur est connecté
    //     if ($user) {
    //         // Filtrer les projets par la commune de l'utilisateur connecté
    //         $projets = Projet::where('commune_id', $user->commune_id)->get();

    //         // Vérifier s'il n'y a aucun projet
    //         if ($projets->isEmpty()) {
    //             return response()->json(['message' => 'Aucun projet disponible pour votre commune.'], 200); // 200 OK
    //         }

    //         // return response()->json($projets, 200); // 200 OK
    //         return $this->Response('Liste des projets', $projets);
    //     }

    //     // Si l'utilisateur n'est pas connecté, retourner une réponse d'erreur
    //     return response()->json(['error' => 'Unauthorized'], 401); // 401 Unauthorized
    // }


   


public function index(Request $request): JsonResponse
{
    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Vérifier si l'utilisateur est connecté
    if ($user) {
        // Initialiser la requête de base
        $query = Projet::where('commune_id', $user->commune_id);

        // Ajouter le filtrage par statut si le paramètre est présent
        if ($request->has('statut')) {
            $statut = filter_var($request->query('statut'), FILTER_VALIDATE_BOOLEAN);
            $query->where('statut', $statut);
        }

        // Exécuter la requête
        $projets = $query->get();

        // Vérifier s'il n'y a aucun projet
        if ($projets->isEmpty()) {
            return response()->json(['message' => 'Aucun projet disponible pour votre commune.'], 200); // 200 OK
        }

        // Retourner les projets
        return response()->json(['message' => 'Liste des projets', 'data' => $projets], 200); // 200 OK
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

    // methode pour mettre a jour le statut du projet

    /**
 * Update the status of the specified resource.
 */
public function updateStatut(Request $request, Projet $projet): JsonResponse
{
    $request->validate([
        'statut' => 'required|boolean', // Assurez-vous que le statut est un booléen
    ]);

    try {
        // Mettre à jour le statut du projet
        $projet->statut = $request->input('statut');
        $projet->save();

        return response()->json(['message' => 'Statut du projet mis à jour avec succès'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Impossible de mettre à jour le statut du projet', 'message' => $e->getMessage()], 500);
    }
}

// recuperer les projtes publies et non publies

/**
 * Display a listing of the published resources.
 */
public function getProjetsPublies(): JsonResponse
{
    $projets = Projet::where('statut', true)->get();
    return response()->json($projets, 200);
}

/**
 * Display a listing of the unpublished resources.
 */
public function getProjetsNonPublies(): JsonResponse
{
    $projets = Projet::where('statut', false)->get();
    return response()->json($projets, 200);
}


// projet soumis d'un user
public function getPublishedProjectsByUser($userId)
    {
        // Filtrer les projets par utilisateur et par statut
        $publishedProjects = Projet::where('user_id', $userId)
                                    ->where('statut', 1)  // Statut 1 signifie publié
                                    ->get();

        return response()->json($publishedProjects);
    }


    public function countTotalProjets() {
        $count = Projet::count(); // Compte tous les projets
        return response()->json(['count' => $count]);
    }
    
    public function countProjetsPublies() {
        $count = Projet::where('statut', true)->count(); // Compte les projets publiés
        return response()->json(['count' => $count]);
    }


}
