<?php

namespace App\Http\Controllers\Auth;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register API - POST (prenom, nom, email, password, etc.)
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'commune_id' => 'nullable|exists:communes,id' ,// Validation pour vérifier que commune_id existe dans la table communes            'prenom' => $request->prenom,
            'prenom' => 'required|string',
            'nom' => 'required|string',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string',
            'lieu_naissance' => 'required|string',
            'fonction' => 'nullable|in:eleve,bachelier,etudiant,diplome,mentor_certifie,profetionnel_reconvertit,retraite,chomeur',
            'genre' => 'required|in:masculin,feminin',
            'telephone' => 'required|string|unique:users',
            'situation_matriminiale' => 'required|in:marie,divorce,celibataire,veuve',
            'date_integration' => 'nullable|date',
            'date_sortie' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('photos', 'public'); // Store in public/photos directory
        }

        // User model to save user in database
        User::create([
            'commune_id' => $request->commune_id, // Ajouter l'ID de la commune
            'nom' => $request->nom,
            'date_naissance' => $request->date_naissance,
            'adresse' => $request->adresse,
            'lieu_naissance' => $request->lieu_naissance,
            'fonction' => $request->fonction,
            'genre' => $request->genre,
            'telephone' => $request->telephone,
            'situation_matriminiale' => $request->situation_matriminiale,
            'date_integration' => $request->date_integration,
            'date_sortie' => $request->date_sortie,
            'photo' => $photoPath,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'data' => [
                'photo' => $photoPath
            ]
        ]);
    }



// Login API - POST (email, password)
public function login(Request $request){

    // Validation
    $request->validate([
        "email" => "required|email",
        "password" => "required"
    ]);

    $token = auth()->attempt([
        "email" => $request->email,
        "password" => $request->password
    ]);

    if(!$token){

        return response()->json([
            "status" => false,
            "message" => "Invalid login details"
        ]);
    }

    return response()->json([
        "status" => true,
        "message" => "User logged in succcessfully",
        "token" => $token,
        "expires_in" => auth()->factory()->getTTL() * 60
    ]);
}

     //DECONNEXION
     public function logout()
     {
        auth()->logout();
        return response()->json(["message" => "Déconnexion réussie"]);
     }

}
