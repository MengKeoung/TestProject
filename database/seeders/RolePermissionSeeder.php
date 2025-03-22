<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Get the roles
        $memberRole = Role::where('name', 'member')->first();
        $customerRole = Role::where('name', 'customer')->first();
        $visitorRole = Role::where('name', 'visitor')->first();
        $partnerRole = Role::where('name', 'partner')->first();

        // Check if roles exist
        if (!$memberRole || !$customerRole || !$visitorRole || !$partnerRole) {
            $this->command->error('Roles not found. Please run the RoleSeeder first.');
            return;
        }

        // Assign permissions to the member role
        $memberPermissions = Permission::whereIn('name', [
            'user.view', 'user.create', 'product.view', 'product.create', 'category.view', 'category.create', 'category.edit', 'category.delete', 'brand.view', 'brand.create', 'brand.edit', 'brand.delete', 'slider.view','promotion.view'
        ])->get();
        $memberRole->permissions()->sync($memberPermissions);

        // Assign permissions to the customer role
        $customerPermissions = Permission::whereIn('name', [
            'product.view', 'product.book'
        ])->get();
        $customerRole->permissions()->sync($customerPermissions);

        // Assign permissions to the visitor role
        $visitorPermissions = Permission::whereIn('name', [
            'product.view', 'category.view'
        ])->get();
        $visitorRole->permissions()->sync($visitorPermissions);

        // Assign permissions to the partner role
        $partnerPermissions = Permission::whereIn('name', [
            'transaction.view','transaction.edit', 'transaction.confirm'
        ])->get();
        $partnerRole->permissions()->sync($partnerPermissions);

        $this->command->info('Permissions assigned to roles successfully.');
    }
}