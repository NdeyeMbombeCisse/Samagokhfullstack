<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $data = User::with('roles')->latest()->paginate($perPage);

        return response()->json($data);
    }

    // Inscrire un Maire sur la plateforme
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = new User();
        $user->fill($request->validated());

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $user->photo = $photo->store('users', 'public');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Attribuer le rôle "maire"
        $userRole = Role::findByName('maire');
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

    // Modifier les rôles d'un utilisateur
    public function updateRoles(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);

        // Validation des rôles
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name', // Assurez-vous que les rôles existent
        ]);

        // Synchroniser les rôles de l'utilisateur
        $roles = $request->input('roles');
        $user->syncRoles($roles);

        return response()->json([
            'status' => true,
            'message' => 'User roles updated successfully',
            'data' => $user->fresh('roles') // Recharger les rôles de l'utilisateur
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    public function getTotalUsers(): JsonResponse
    {
        $totalUsers = User::count();

        return response()->json($totalUsers);
    }
}
