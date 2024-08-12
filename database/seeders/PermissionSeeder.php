<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
            //Role
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            //project
            'project-list',
            'project-create',
            'project-edit',
            'project-delete',

            //ville
            'ville-list',
            'ville-create',
            'ville-edit',
            'ville-delete',

             //vote
             'vote-list',
             'vote-create',
             'vote-edit',
             'vote-delete',

              //commune
              'commune-list',
              'commune-create',
              'commune-edit',
              'commune-delete',

              //commentaire
              'commentaire-list',
              'commentaire-create',
              'commentaire-edit',
              'commentaire-delete',

              //admin
              'admin-list',
              'admin-create',
              'admin-edit',
              'admin-delete',
         ];
         
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
