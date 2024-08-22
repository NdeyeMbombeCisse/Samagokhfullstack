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
    function __construct()
    {
        // Permissions removed
        // $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:project-create', ['only' => ['store']]);
        // $this->middleware('permission:project-edit', ['only' => ['update']]);
        // $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        $user = Auth::user();
        if ($user) {
            $projets = Projet::where('commune_id', $user->commune_id)->get();
            if ($projets->isEmpty()) {
                return response()->json(['message' => 'Aucun projet disponible pour votre commune.'], 200);
            }
            return response()->json($projets, 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function store(StoreProjetRequest $request): JsonResponse
    {
        try {
            $projet = Projet::create(array_merge(
                $request->validated(),
                ['user_id' => Auth::id()]
            ));
            Notification::send(User::all(), new NewProjectNotification($projet));
            return response()->json($projet, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to create project', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Projet $projet): JsonResponse
    {
        return response()->json($projet, 200);
    }

    public function update(UpdateProjetRequest $request, Projet $projet): JsonResponse
    {
        $projet->update($request->validated());
        return response()->json($projet, 200);
    }

    public function destroy(Projet $projet): JsonResponse
    {
        $projet->delete();
        return response()->json(null, 204);
    }
}
