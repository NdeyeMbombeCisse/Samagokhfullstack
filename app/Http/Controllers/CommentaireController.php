<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentaireRequest;
use App\Http\Requests\UpdateCommentaireRequest;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class CommentaireController extends Controller
{
    // GET: /api/commentaires
    public function index()
    {
        $commentaires = Commentaire::all();
        return response()->json([
            'message' => 'Liste des commentaires récupérée avec succès',
            'data' => $commentaires
        ], 200);
    }

    // POST: /api/commentaires
    public function store(StoreCommentaireRequest $request)
    {
        $commentaire = Commentaire::create($request->validated());
        return response()->json([
            'message' => 'Commentaire créé avec succès',
            'data' => $commentaire
        ], 201);
    }

    // GET: /api/commentaires/{id}
    public function show($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        return response()->json([
            'message' => 'Commentaire récupéré avec succès',
            'data' => $commentaire
        ], 200);
    }

    // PUT/PATCH: /api/commentaires/{id}
    public function update(UpdateCommentaireRequest $request, Commentaire $commentaire): JsonResponse
    {
        // Mise à jour des champs en utilisant les données validées
        $commentaire->update($request->validated());

        // Retourner une réponse JSON avec un message de succès
        return response()->json([
            'message' => 'Commentaire mis à jour avec succès',
            'data' => $commentaire
        ], 200);
    }


    // DELETE: /api/commentaires/{id}
    public function destroy($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        $commentaire->delete();
        return response()->json([
            'message' => 'Commentaire supprimé avec succès'
        ], 200); // 200 plutôt que 204 pour pouvoir inclure un message
    }
}
