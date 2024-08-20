<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Role
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            // Project
            'project-list',
            'project-create',
            'project-edit',
            'project-delete',
            // Ville
            'ville-list',
            'ville-create',
            'ville-edit',
            'ville-delete',
            // Vote
            'vote-list',
            'vote-create',
            'vote-edit',
            'vote-delete',
            // Commune
            'commune-list',
            'commune-create',
            'commune-edit',
            'commune-delete',
            // Commentaire
            'commentaire-list',
            'commentaire-create',
            'commentaire-edit',
            'commentaire-delete',
            // Admin
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Créer ou récupérer le rôle "user"
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Définir les permissions par défaut pour le rôle "user"
        $defaultUserPermissions = [
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

        // Assigner les permissions par défaut au rôle "user"
        foreach ($defaultUserPermissions as $permission) {
            $userRole->givePermissionTo($permission);
        }
    }
}