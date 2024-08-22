<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    // Enregistrement d'un nouvel utilisateur
    public function register(StoreUserRequest $request)
    {
        $user = new User();
        $user->fill($request->validated());

        // Upload de la photo de profil
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $user->role->default("habitant");
            $user->photo = $photo->store('users', 'public');
        }

        // Hachage du mot de passe
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'photo' => $user->photo
            ]
        ], 201);
    }

    // API de connexion - POST (email, mot de passe)
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $token = auth()->attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if (!$token) {
            return response()->json([
                "status" => false,
                "message" => "Invalid login details"
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "User logged in successfully",
            "token" => $token,
            "expires_in" => auth()->factory()->getTTL() * 60
        ]);
    }

    // Déconnexion
    public function logout()
    {
        auth()->logout();
        return response()->json(["message" => "Déconnexion réussie"]);
    }

    // Mise à jour des informations de l'utilisateur
    public function update(UpdateUserRequest $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        // Gestion de l'upload de la photo
        $photoPath = $user->photo;
        if ($request->hasFile('photo')) {
            if (File::exists(public_path("storage/" . $user->photo))) {
                File::delete(public_path($user->photo));
            }
            $photo = $request->file('photo');
            $photoPath = $photo->store('photos', 'public');
        }

        // Mise à jour des détails de l'utilisateur
        $user->update([
            'commune_id' => $request->commune_id,
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'date_naissance' => $request->date_naissance,
            'adresse' => $request->adresse,
            'lieu_naissance' => $request->lieu_naissance,
            'fonction' => $request->fonction,
            'genre' => $request->genre,
            'telephone' => $request->telephone,
            'date_integration' => $request->date_integration,
            'date_sortie' => $request->date_sortie,
            'photo' => $photoPath,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profil mis à jour avec succès',
            'data' => $user
        ]);
    }

    // Suppression logique (soft delete) de l'utilisateur
    public function softDelete()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User account soft deleted successfully'
        ]);
    }

    // Actualisation du token (JWT Auth Token)
    public function refreshToken()
    {
        $token = auth()->refresh();
        return response()->json([
            "status" => true,
            "message" => "New access Token",
            "token" => $token,
            "expires_in" => auth()->factory()->getTTL() * 60
        ]);
    }

    // Restauration de l'utilisateur supprimé logiquement
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->restore();
            return $user;
        }
        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    }
}
