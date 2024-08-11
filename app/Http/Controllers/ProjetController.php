<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projet;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreProjetRequest;
use App\Http\Requests\UpdateProjetRequest;
use App\Notifications\NewProjectNotification;


class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $projets = Projet::all();
        return response()->json($projets, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjetRequest $request): JsonResponse
{
    $projet = Projet::create($request->validated());

    // Envoyer la notification à tous les utilisateurs
    $users = User::all();
    foreach ($users as $user) {
        $user->notify(new NewProjectNotification($projet));
    }

    return response()->json($projet, 201); // 201 Created
}


    /**
     * Display the specified resource.
     */
    public function show(Projet $projet): JsonResponse
    {
        return response()->json($projet, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */


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
