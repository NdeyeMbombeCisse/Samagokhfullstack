<?php

namespace App\Http\Controllers\Auth;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register API - POST (prenom, nom, email, password, etc.)
    public function register(StoreUserRequest $request)
    {
        $user = new User();
    $user->fill($request->validated());

    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $user->photo = $photo->store('users', 'public');
    }

    $user->password = Hash::make($request->password);
    $user->save();

    // Attribuer le rôle "user"
    $userRole = Role::findByName('user');
    $user->assignRole($userRole);

    return response()->json([
        'status' => true,
        'message' => 'User registered successfully and assigned user role',
        'data' => [
            'user' => $user,
            'photo' => $user->photo
        ]
    ], 201);
    }

    // Login API - POST (email, password)
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

        if(!$token){
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

    //DECONNEXION
    public function logout()
    {
        auth()->logout();
        return response()->json(["message" => "Déconnexion réussie"]);
    }

    public function update(UpdateUserRequest $request)
    {
        // Find the authenticated user
        $user = auth()->user();

        // Handle file upload
        $photoPath = $user->photo;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('photos', 'public');
        }

        // Update user details
        $user->update([
            'commune_id' => $request->commune_id,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
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
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User details updated successfully',
            'data' => [
                'photo' => $photoPath
            ]
        ]);
    }

    //SoftDeletes
    public function softDelete()
    {
        $user = auth()->user();
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User account soft deleted successfully'
        ]);
    }
}