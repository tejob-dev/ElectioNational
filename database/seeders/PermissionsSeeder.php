<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list agentdesections']);
        Permission::create(['name' => 'view agentdesections']);
        Permission::create(['name' => 'create agentdesections']);
        Permission::create(['name' => 'update agentdesections']);
        Permission::create(['name' => 'delete agentdesections']);

        Permission::create(['name' => 'list agentdubureauvotes']);
        Permission::create(['name' => 'view agentdubureauvotes']);
        Permission::create(['name' => 'create agentdubureauvotes']);
        Permission::create(['name' => 'update agentdubureauvotes']);
        Permission::create(['name' => 'delete agentdubureauvotes']);

        Permission::create(['name' => 'list agentterrains']);
        Permission::create(['name' => 'view agentterrains']);
        Permission::create(['name' => 'create agentterrains']);
        Permission::create(['name' => 'update agentterrains']);
        Permission::create(['name' => 'delete agentterrains']);

        Permission::create(['name' => 'list bureauvotes']);
        Permission::create(['name' => 'view bureauvotes']);
        Permission::create(['name' => 'create bureauvotes']);
        Permission::create(['name' => 'update bureauvotes']);
        Permission::create(['name' => 'delete bureauvotes']);

        Permission::create(['name' => 'list candidats']);
        Permission::create(['name' => 'view candidats']);
        Permission::create(['name' => 'create candidats']);
        Permission::create(['name' => 'update candidats']);
        Permission::create(['name' => 'delete candidats']);

        Permission::create(['name' => 'list communes']);
        Permission::create(['name' => 'view communes']);
        Permission::create(['name' => 'create communes']);
        Permission::create(['name' => 'update communes']);
        Permission::create(['name' => 'delete communes']);

        Permission::create(['name' => 'list departements']);
        Permission::create(['name' => 'view departements']);
        Permission::create(['name' => 'create departements']);
        Permission::create(['name' => 'update departements']);
        Permission::create(['name' => 'delete departements']);

        Permission::create(['name' => 'list lieuvotes']);
        Permission::create(['name' => 'view lieuvotes']);
        Permission::create(['name' => 'create lieuvotes']);
        Permission::create(['name' => 'update lieuvotes']);
        Permission::create(['name' => 'delete lieuvotes']);

        Permission::create(['name' => 'list parrains']);
        Permission::create(['name' => 'view parrains']);
        Permission::create(['name' => 'create parrains']);
        Permission::create(['name' => 'update parrains']);
        Permission::create(['name' => 'delete parrains']);

        Permission::create(['name' => 'list procesverbals']);
        Permission::create(['name' => 'view procesverbals']);
        Permission::create(['name' => 'create procesverbals']);
        Permission::create(['name' => 'update procesverbals']);
        Permission::create(['name' => 'delete procesverbals']);

        Permission::create(['name' => 'list quartiers']);
        Permission::create(['name' => 'view quartiers']);
        Permission::create(['name' => 'create quartiers']);
        Permission::create(['name' => 'update quartiers']);
        Permission::create(['name' => 'delete quartiers']);

        Permission::create(['name' => 'list sections']);
        Permission::create(['name' => 'view sections']);
        Permission::create(['name' => 'create sections']);
        Permission::create(['name' => 'update sections']);
        Permission::create(['name' => 'delete sections']);

        Permission::create(['name' => 'list suplieudevotes']);
        Permission::create(['name' => 'view suplieudevotes']);
        Permission::create(['name' => 'create suplieudevotes']);
        Permission::create(['name' => 'update suplieudevotes']);
        Permission::create(['name' => 'delete suplieudevotes']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
