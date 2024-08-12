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
        //upload user's profil
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $user->photo = $photo->store('users', 'public');
    }
    //hashed password
    $user->password = Hash::make($request->password);
    //save the data of the user
    $user->save();

  // Attribuer le rôle "user"
$userRole = Role::findByName('user');
$user->assignRole($userRole);

// Attribuer les permissions par défaut
$defaultPermissions = [
    //Project-permission
    'project-list',
    'project-create',
    'project-edit',
    'project-delete',
    // //role-permission
    // 'role-list',
    // 'role-create',
    // 'role-edit',
    // 'role-delete',
    //project
    'project-list',
    'project-create',
    'project-edit',
    'project-delete',

     //vote
     'vote-list',
     'vote-create',
     'vote-edit',
     'vote-delete',


      //commentaire
      'commentaire-list',
      'commentaire-create',
      'commentaire-edit',
      'commentaire-delete',

];

foreach ($defaultPermissions as $permissionName) {
    $permission = Permission::findByName($permissionName);
    $user->givePermissionTo($permission);
}
    //response json for the processus save
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
        // // Find the authenticated user
        $user = auth()->user();
        $user->fill($request->validated());
        if ($request->hasFile('photo')) {

            if (File::exists(public_path("storage/" . $user->photo))) {
                File::delete(public_path($user->photo));
            }
            $photo = $request->file('photo');
            $user->photo = $photo->store('users', 'public');
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->update($request->all());
        return response()->json([
        'status' => true,
        'message' => 'Profil mis à jour avec succès',
        'data' => $user
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
