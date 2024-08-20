<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les rôles seulement s'ils n'existent pas déjà
        $roles = [
            'user',
            'admin',
            'maire',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Récupérer les rôles fraîchement créés
        $userRole = Role::where('name', 'user')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $maireRole = Role::where('name', 'maire')->first();

        // Récupérer toutes les permissions
        $allPermissions = Permission::all()->pluck('name')->toArray();

        // Assigner les permissions aux rôles
        $userPermissions = [
            'project-list', 'project-create', 'project-edit', 'project-delete',
            'vote-list', 'vote-create', 'vote-edit', 'vote-delete',
            'commentaire-list', 'commentaire-create', 'commentaire-edit', 'commentaire-delete',
        ];

        $adminPermissions = Permission::all()->pluck('name')->toArray(); // L'admin a toutes les permissions

        $mairePermissions = [
            'project-list', 'project-create', 'project-edit', 'project-delete',
            'vote-list', 'vote-create', 'vote-edit', 'vote-delete',
            'commentaire-list', 'commentaire-create', 'commentaire-edit', 'commentaire-delete',
        ];

        // Assigner les permissions aux rôles
        $userRole->syncPermissions($userPermissions);
        $adminRole->syncPermissions($allPermissions);
        $maireRole->syncPermissions($mairePermissions);
    }
}
