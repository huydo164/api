<?php

namespace Modules\Role\Seeders;

use Illuminate\Database\Seeder;
use Modules\Role\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::updateOrCreate(['name' => Role::ADMIN]);

        $actions = ['index', 'store', 'show', 'update', 'destroy'];

        foreach ($actions as $key) {
            Permission::updateOrCreate(['name' => 'role.' . $key]);
        }
    }
}
