<?php

namespace Modules\User\Seeders;

use Illuminate\Database\Seeder;
use Modules\Role\Models\Role;
use Modules\User\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $actions = ['index', 'store', 'show', 'update', 'destroy'];

        foreach ($actions as $key) {
            Permission::updateOrCreate(['name' => 'user.' . $key]);
        }

        $now = now()->timestamp;

        $user = User::updateOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'password' => bcrypt('admin123'),
                'company_name' => 'Admin',
                'business_type' => 1,
                'company_size' => 1,
                'business_stage' => 1,
                'founding_date' => $now,
                'start_tax_settlement' => $now,
                'end_tax_settlement' => $now,
            ]
        );

        $user->syncRoles(Role::ADMIN);
    }
}
