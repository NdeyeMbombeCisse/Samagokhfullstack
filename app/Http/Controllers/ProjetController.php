<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projet;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreProjetRequest;
use App\Http\Requests\UpdateProjetRequest;
use App\Notifications\NewProjectNotification;
use Illuminate\Support\Facades\Notification;

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
        $projets = Projet::all();
        return response()->json($projets, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjetRequest $request): JsonResponse
    {
        try {
            $projet = Projet::create($request->validated());

            // Send notification to all users
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
