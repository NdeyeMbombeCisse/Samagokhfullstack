<?php


namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Vérifier si l'utilisateur peut voir les permissions.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        // Vérifiez si l'utilisateur a le rôle 'admin'
        return $user->hasRole('admin');
    }
}
