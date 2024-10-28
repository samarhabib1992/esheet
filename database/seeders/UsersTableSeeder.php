<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder 
{
    public function run()
    {
        // Define permissions with display_name and group
        $permissions = [
            // User Permissions
            ['name' => 'user.view', 'display_name' => 'View User', 'group' => 'User'],
            ['name' => 'user.create', 'display_name' => 'Add User', 'group' => 'User'],
            ['name' => 'user.edit', 'display_name' => 'Edit User', 'group' => 'User'],
            ['name' => 'user.delete', 'display_name' => 'Delete User', 'group' => 'User'],

            // Role Permissions
            ['name' => 'role.view', 'display_name' => 'View Role', 'group' => 'Role'],
            ['name' => 'role.create', 'display_name' => 'Add Role', 'group' => 'Role'],
            ['name' => 'role.edit', 'display_name' => 'Edit Role', 'group' => 'Role'],
            ['name' => 'role.delete', 'display_name' => 'Delete Role', 'group' => 'Role'],

            // Product Permissions
            ['name' => 'product.view', 'display_name' => 'View Product', 'group' => 'Product'],
            ['name' => 'product.create', 'display_name' => 'Add Product', 'group' => 'Product'],
            ['name' => 'product.edit', 'display_name' => 'Edit Product', 'group' => 'Product'],
            ['name' => 'product.delete', 'display_name' => 'Delete Product', 'group' => 'Product'],

            ['name' => 'productType.view', 'display_name' => 'View Product Type', 'group' => 'Product'],
            ['name' => 'productType.create', 'display_name' => 'Add Product Type', 'group' => 'Product'],
            ['name' => 'productType.edit', 'display_name' => 'Edit Product Type', 'group' => 'Product'],
            ['name' => 'productType.delete', 'display_name' => 'Delete Product Type', 'group' => 'Product'],

            ['name' => 'productCategory.view', 'display_name' => 'View Product Category', 'group' => 'Product'],
            ['name' => 'productCategory.create', 'display_name' => 'Add Product Category', 'group' => 'Product'],
            ['name' => 'productCategory.edit', 'display_name' => 'Edit Product Category', 'group' => 'Product'],
            ['name' => 'productCategory.delete', 'display_name' => 'Delete Product Category', 'group' => 'Product'],

            ['name' => 'productTopic.view', 'display_name' => 'View Product Topic', 'group' => 'Product'],
            ['name' => 'productTopic.create', 'display_name' => 'Add Product Topic', 'group' => 'Product'],
            ['name' => 'productTopic.edit', 'display_name' => 'Edit Product Topic', 'group' => 'Product'],
            ['name' => 'productTopic.delete', 'display_name' => 'Delete Product Topic', 'group' => 'Product'],

            // Blog Permissions
            ['name' => 'blog.view', 'display_name' => 'View Blog', 'group' => 'Blog'],
            ['name' => 'blog.create', 'display_name' => 'Add Blog', 'group' => 'Blog'],
            ['name' => 'blog.edit', 'display_name' => 'Edit Blog', 'group' => 'Blog'],
            ['name' => 'blog.delete', 'display_name' => 'Delete Blog', 'group' => 'Blog'],

            // Blog Category Permissions
            ['name' => 'blogcategory.view', 'display_name' => 'View Blog Category', 'group' => 'Blog'],
            ['name' => 'blogcategory.create', 'display_name' => 'Add Blog Category', 'group' => 'Blog'],
            ['name' => 'blogcategory.edit', 'display_name' => 'Edit Blog Category', 'group' => 'Blog'],
            ['name' => 'blogcategory.delete', 'display_name' => 'Delete Blog Category', 'group' => 'Blog'],

            // Customer Permissions
            ['name' => 'customer.view', 'display_name' => 'View Customer', 'group' => 'Customer'],

            // Sale Permissions
            ['name' => 'sale.view', 'display_name' => 'View Sale', 'group' => 'Sale'],

            // Report Permissions
            ['name' => 'report.view', 'display_name' => 'View Report', 'group' => 'Report'],

            // Setting Permissions
            ['name' => 'setting.view', 'display_name' => 'View Setting', 'group' => 'Setting'],
            ['name' => 'setting.create', 'display_name' => 'Add Setting', 'group' => 'Setting'],
            ['name' => 'setting.edit', 'display_name' => 'Edit Setting', 'group' => 'Setting'],
            ['name' => 'setting.delete', 'display_name' => 'Delete Setting', 'group' => 'Setting'],
        ];

        // Create permissions in the database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'guard_name' => 'web',
            ], [
                'display_name' => $permission['display_name'],
                'group' => $permission['group'],
            ]);
        }

        // Create Super Admin role
        $superAdminRole  = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        // Assign all permissions to the Super Admin role
        $superAdminRole->givePermissionTo(Permission::all());

        // Insert a default user record with the Super Admin role
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@esheet.com',
            'password' => Hash::make('esheet'), 
            'mobile_number' => '1234567890',
            'user_type' => 'system',
            'status' => '1',
            'role_id' => $superAdminRole->id,
        ]);
    }
}
