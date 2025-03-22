<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define roles
        $data = [
            [
                'id'         => 1,
                'name'       => 'admin',
                'guard_name' => 'web',
            ],
            [
                'id'         => 2,
                'name'       => 'member',
                'guard_name' => 'web',
            ],
            [
                'id'         => 3,
                'name'       => 'customer',
                'guard_name' => 'web',
            ],
            [
                'id'         => 4,
                'name'       => 'visitor',
                'guard_name' => 'web',
            ],
            [
                'id'         => 5,
                'name'       => 'partner',
                'guard_name' => 'web',
            ]
        ];

        // Create roles if they don't exist
        foreach ($data as $roleData) {
            Role::firstOrCreate(['name' => $roleData['name']], $roleData);
        }

        // Assign all permissions to the admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $permissions = Permission::all();
            if ($permissions->isNotEmpty()) {
                $adminRole->givePermissionTo($permissions);
                $this->command->info('All permissions assigned to the admin role.');
            } else {
                $this->command->warn('No permissions found. Please run the PermissionsSeeder first.');
            }
        } else {
            $this->command->error('Admin role not found.');
        }
    }
}