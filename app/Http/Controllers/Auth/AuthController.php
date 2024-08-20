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
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register for the user xhith user permisssion defauld
    public function register(StoreUserRequest $request)
    {
        $user = new User();
        $user->fill($request->validated());

        // Upload user's profile photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $user->photo = $photo->store('users', 'public');
        }

        // Hash password
        $user->password = Hash::make($request->password);
        $user->save();

        // Assign default role
        $userRole = Role::findByName('user');
        $user->assignRole($userRole);

        // Assign default permissions
        $defaultPermissions = [
            'project-list',
            'project-create',
            'project-edit',
            'project-delete',
            'vote-list',
            'vote-create',
            'vote-edit',
            'vote-delete',
            'commentaire-list',
            'commentaire-create',
            'commentaire-edit',
            'commentaire-delete',
        ];

        foreach ($defaultPermissions as $permissionName) {
            $permission = Permission::findByName($permissionName);
            $user->givePermissionTo($permission);
        }

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
    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not authenticated',
        ], 401);
    }

    // Gestion de l'upload de la photo
    $photoPath = $user->photo; // Conserve le chemin actuel de la photo si aucune nouvelle photo n'est uploadée
    if ($request->hasFile('photo')) {
        if (File::exists(public_path("storage/" . $user->photo))) {
            File::delete(public_path($user->photo));
        }
        $photo = $request->file('photo');
        $photoPath = $photo->store('photos', 'public'); // Stocke la nouvelle photo
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







    //SoftDeletes
    public function softDelete()
{
    // Trouver l'utilisateur authentifié
    $user = auth()->user();

    // Vérifiez si l'utilisateur est authentifié
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not authenticated',
        ], 401);
    }

    // Supprime l'utilisateur de manière logique
    $user->delete();

    return response()->json([
        'status' => true,
        'message' => 'User account soft deleted successfully'
    ]);
}


     // Refresh Token API - GET (JWT Auth Token)
     public function refreshToken(){
        $token = auth()->refresh();
        return response()->json([
            "status" => true,
            "message"=> "New access Token",
            "token"=>$token,
            "expires_in" => auth()->factory()->getTTL() * 60
        ]);
     }

     //restor the user softDelete
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
