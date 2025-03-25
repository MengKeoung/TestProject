<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class addRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'role.view',
            'guard_name' => 'web',
            'display' => 'View Roles',
            'module' => 'Role'
        ]);
    }
}
