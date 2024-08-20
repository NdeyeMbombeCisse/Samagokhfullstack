<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Liste des permissions à créer
        $permissions = [
            'role-list', 'role-create', 'role-edit', 'role-delete',
            'project-list', 'project-create', 'project-edit', 'project-delete',
            'vote-list', 'vote-create', 'vote-edit', 'vote-delete',
            'commentaire-list', 'commentaire-create', 'commentaire-edit', 'commentaire-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
