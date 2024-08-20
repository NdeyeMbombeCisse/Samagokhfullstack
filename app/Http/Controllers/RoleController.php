<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //      $this->middleware('auth:api');
    //     $this->middleware('permission:role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:role-list', ['only' => ['index']]);
    //     $this->middleware('permission:role-create', ['only' => ['store']]);
    //     $this->middleware('permission:role-edit', ['only' => ['update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $roles = Role::with('permissions')->orderBy('id', 'ASC')->paginate(10);
        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): JsonResponse
{
    $role = Role::create(['name' => $request->name]);

    if ($request->has('permissions') && is_array($request->permissions)) {
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        $role->syncPermissions($permissions);
    }

    // Assign default permissions to the 'user' role
    if ($role->name === 'user') {
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
            $role->givePermissionTo($permission);
        }
    }

    return response()->json([
        'message' => 'New role is added successfully.',
        'role' => $role
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        return response()->json($role->load('permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        if ($role->name === 'SuperAdmin') {
            return response()->json(['message' => 'SUPER ADMIN ROLE CAN NOT BE EDITED'], 403);
        }

        $role->update($request->only('name'));

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        $role->syncPermissions($permissions);

        return response()->json([
            'message' => 'Role is updated successfully.',
            'role' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        // Vérification si le rôle est "Super Admin"
    if ($role->name === 'SuperAdmin') {
        return response()->json(['message' => 'SUPER ADMIN ROLE CAN NOT BE DELETED'], 403);
    }

    // Vérification si l'utilisateur est authentifié
    if ($user = auth()->user()) {
        // Vérification si l'utilisateur a le rôle qu'il essaie de supprimer
        if ($user->hasRole($role->name)) {
            return response()->json(['message' => 'CAN NOT DELETE SELF ASSIGNED ROLE'], 403);
        }
    } else {
        // Si l'utilisateur n'est pas authentifié, retourner une réponse d'erreur
        return response()->json(['message' => "Unauthorized"], 401);
    }

    // Suppression du rôle
    $role->delete();
    return response()->json(['message' => 'Role is deleted successfully.']);
}

//récupération des permissions par rapport aux roles
public function getRolePermissions($roleId)
{
    $role = Role::findById($roleId);
    return response()->json($role->permissions);
}
}
