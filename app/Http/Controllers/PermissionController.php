<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    // Récupération de tous les permissions
    public function __construct()
    {
        // Appliquer le middleware 'auth' pour s'assurer que l'utilisateur est authentifié
        $this->middleware('auth:api');

        // Appliquer le middleware 'can:view-any,App\Models\Permission' pour vérifier les autorisations
        $this->middleware('can:view-any,' . Permission::class);
    }

    public function getPermissions()
    {
        return response()->json(Permission::all());
    }
}
