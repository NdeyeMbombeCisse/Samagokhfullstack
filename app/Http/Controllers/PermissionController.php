<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //récupération de tous les permissions
    public function getPermissions()
    {
    return response()->json(Permission::all());
    }


}
