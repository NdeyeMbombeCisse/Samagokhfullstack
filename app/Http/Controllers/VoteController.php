<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoteRequest;
use App\Http\Requests\UpdateVoteRequest;
use App\Models\Vote;
use Illuminate\Http\JsonResponse;

class VoteController extends Controller
{
    // GET: /api/votes
    public function index(): JsonResponse
    {
        $votes = Vote::all();
        return response()->json([
            'message' => 'Liste des votes récupérée avec succès',
            'data' => $votes
        ], 200);
    }

    // POST: /api/votes
    public function store(StoreVoteRequest $request): JsonResponse
    {
        $vote = Vote::create($request->validated());
        return response()->json([
            'message' => 'Vote créé avec succès',
            'data' => $vote
        ], 201);
    }

    // GET: /api/votes/{vote}
    public function show(Vote $vote): JsonResponse
    {
        return response()->json([
            'message' => 'Vote récupéré avec succès',
            'data' => $vote
        ], 200);
    }

    // PUT/PATCH: /api/votes/{vote}
    public function update(UpdateVoteRequest $request, Vote $vote): JsonResponse
    {
        $vote->update($request->validated());
        return response()->json([
            'message' => 'Vote mis à jour avec succès',
            'data' => $vote
        ], 200);
    }

    // DELETE: /api/votes/{vote}
    public function destroy(Vote $vote): JsonResponse
    {
        $vote->delete();
        return response()->json([
            'message' => 'Vote supprimé avec succès'
        ], 200);
    }
}
