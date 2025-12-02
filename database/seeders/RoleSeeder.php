<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'can access roles']);
        Permission::create(['name' => 'can access permissions']);
        Permission::create(['name' => 'can add roles']);
        Permission::create(['name' => 'can edit roles']);
        Permission::create(['name' => 'can manage roles']);
        Permission::create(['name' => 'can delete roles']);
        Permission::create(['name' => 'can make permissions']);
        Permission::create(['name' => 'can edit permissions']);
        Permission::create(['name' => 'can delete permissions']);
        Permission::create(['name' => 'can access users']);
        Permission::create(['name' => 'can create users']);
        Permission::create(['name' => 'can edit users']);
        Permission::create(['name' => 'can delete users']);
        Permission::create(['name' => 'can manage access users']);
        Permission::create(['name' => 'can access departments']);
        Permission::create(['name' => 'can create departments']);
        Permission::create(['name' => 'can edit departments']);
        Permission::create(['name' => 'can delete departments']);
        Permission::create(['name' => 'can access plants']);
        Permission::create(['name' => 'can create plants']);
        Permission::create(['name' => 'can edit plants']);
        Permission::create(['name' => 'can delete plants']);

        $roleSuperadmin = Role::create(['name' => 'Superadmin']);
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleUser = Role::create(['name' => 'User']);
        $roleSuperadmin->givePermissionTo(Permission::all());
    }
}
