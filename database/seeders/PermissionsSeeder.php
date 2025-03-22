<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks to avoid constraint issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate the permissions table and reset auto-increment
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // User Management Permissions
        Permission::create(['name' => 'user.view', 'guard_name' => 'web', 'display' => 'View Users', 'module' => 'User']);
        Permission::create(['name' => 'user.create', 'guard_name' => 'web', 'display' => 'Create User', 'module' => 'User']);
        Permission::create(['name' => 'user.edit', 'guard_name' => 'web', 'display' => 'Edit User', 'module' => 'User']);
        Permission::create(['name' => 'user.delete', 'guard_name' => 'web', 'display' => 'Delete User', 'module' => 'User']);

        // Product Management Permissions
        Permission::create(['name' => 'product.view', 'guard_name' => 'web', 'display' => 'View Products', 'module' => 'Product']);
        Permission::create(['name' => 'product.create', 'guard_name' => 'web', 'display' => 'Create Product', 'module' => 'Product']);
        Permission::create(['name' => 'product.edit', 'guard_name' => 'web', 'display' => 'Edit Product', 'module' => 'Product']);
        Permission::create(['name' => 'product.delete', 'guard_name' => 'web', 'display' => 'Delete Product', 'module' => 'Product']);
        Permission::create(['name' => 'product.book', 'guard_name' => 'web', 'display' => 'Book Product', 'module' => 'Product']);

        // Category Permissions
        Permission::create(['name' => 'category.view', 'guard_name' => 'web', 'display' => 'View Categories', 'module' => 'Category']);
        Permission::create(['name' => 'category.create', 'guard_name' => 'web', 'display' => 'Create Category', 'module' => 'Category']);
        Permission::create(['name' => 'category.edit', 'guard_name' => 'web', 'display' => 'Edit Category', 'module' => 'Category']);
        Permission::create(['name' => 'category.delete', 'guard_name' => 'web', 'display' => 'Delete Category', 'module' => 'Category']);

        // Brand Permissions
        Permission::create(['name' => 'brand.view', 'guard_name' => 'web', 'display' => 'View Brands', 'module' => 'Brand']);
        Permission::create(['name' => 'brand.create', 'guard_name' => 'web', 'display' => 'Create Brand', 'module' => 'Brand']);
        Permission::create(['name' => 'brand.edit', 'guard_name' => 'web', 'display' => 'Edit Brand', 'module' => 'Brand']);
        Permission::create(['name' => 'brand.delete', 'guard_name' => 'web', 'display' => 'Delete Brand', 'module' => 'Brand']);

        // Transaction Management Permissions
        Permission::create(['name' => 'transaction.view', 'guard_name' => 'web', 'display' => 'View Transactions', 'module' => 'Transaction']);
        Permission::create(['name' => 'transaction.create', 'guard_name' => 'web', 'display' => 'Create Transaction', 'module' => 'Transaction']);
        Permission::create(['name' => 'transaction.edit', 'guard_name' => 'web', 'display' => 'Edit Transaction', 'module' => 'Transaction']);
        Permission::create(['name' => 'transaction.delete', 'guard_name' => 'web', 'display' => 'Delete Transaction', 'module' => 'Transaction']);
        Permission::create(['name' => 'transaction.confirm', 'guard_name' => 'web', 'display' => 'Confirm Transaction', 'module' => 'Transaction']);
        Permission::create(['name' => 'transaction.request', 'guard_name' => 'web', 'display' => 'Request Transaction', 'module' => 'Transaction']);

        // Settings Permissions
        Permission::create(['name' => 'setting.view', 'guard_name' => 'web', 'display' => 'View Settings', 'module' => 'Settings']);
        Permission::create(['name' => 'setting.edit', 'guard_name' => 'web', 'display' => 'Edit Settings', 'module' => 'Settings']);

        // Additional Modules
        Permission::create(['name' => 'slider.view', 'guard_name' => 'web', 'display' => 'View Sliders', 'module' => 'Slider']);
        Permission::create(['name' => 'slider.create', 'guard_name' => 'web', 'display' => 'Create Slider', 'module' => 'Slider']);
        Permission::create(['name' => 'slider.edit', 'guard_name' => 'web', 'display' => 'Edit Slider', 'module' => 'Slider']);
        Permission::create(['name' => 'slider.delete', 'guard_name' => 'web', 'display' => 'Delete Slider', 'module' => 'Slider']);

        Permission::create(['name' => 'promotion.view', 'guard_name' => 'web', 'display' => 'View Promotions', 'module' => 'Promotion']);
        Permission::create(['name' => 'promotion.create', 'guard_name' => 'web', 'display' => 'Create Promotion', 'module' => 'Promotion']);
        Permission::create(['name' => 'promotion.edit', 'guard_name' => 'web', 'display' => 'Edit Promotion', 'module' => 'Promotion']);
        Permission::create(['name' => 'promotion.delete', 'guard_name' => 'web', 'display' => 'Delete Promotion', 'module' => 'Promotion']);

        Permission::create(['name' => 'customer.view', 'guard_name' => 'web', 'display' => 'View Customers', 'module' => 'Customer']);
        Permission::create(['name' => 'customer.create', 'guard_name' => 'web', 'display' => 'Create Customer', 'module' => 'Customer']);
        Permission::create(['name' => 'customer.edit', 'guard_name' => 'web', 'display' => 'Edit Customer', 'module' => 'Customer']);
        Permission::create(['name' => 'customer.delete', 'guard_name' => 'web', 'display' => 'Delete Customer', 'module' => 'Customer']);
    }
}