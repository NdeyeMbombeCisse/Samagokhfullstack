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
    public function __construct()
    {
         $this->middleware('auth:api');
        $this->middleware('permission:role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['store']]);
        $this->middleware('permission:role-edit', ['only' => ['update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $roles = Role::with('permissions')->orderBy('id', 'DESC')->paginate(3);
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
        if ($role->name === 'Super Admin') {
            return response()->json(['message' => 'SUPER ADMIN ROLE CAN NOT BE DELETED'], 403);
        }
        if (auth()->user()->hasRole($role->name)) {
            return response()->json(['message' => 'CAN NOT DELETE SELF ASSIGNED ROLE'], 403);
        }

        $role->delete();
        return response()->json(['message' => 'Role is deleted successfully.']);
    }
}
