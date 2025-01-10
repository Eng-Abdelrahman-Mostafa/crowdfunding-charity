<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions from config
        $permissionsGroups = config('permissions-roles.permissions');

        // Create permissions in database
        foreach ($permissionsGroups as $groupPermissions) {
            foreach ($groupPermissions as $permission) {
                Permission::firstOrCreate(
                    ['name' => $permission['name']],
                    ['guard_name' => $permission['guard_name']]
                );
            }
        }

        // Create roles from config
        $roles = config('permissions-roles.roles');

        // Create roles and assign permissions
        foreach ($roles as $roleName => $roleConfig) {
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                ['guard_name' => $roleConfig['guard_name']]
            );

            // Sync permissions for the role
            $role->syncPermissions($roleConfig['permissions']);
        }

        // Create admin user if it doesn't exist
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'phone' => '1234567890',
                'password' => Hash::make('password'),
                'type' => 'admin',
            ]
        );

        // Assign super-admin role to admin user
        if (!$adminUser->hasRole('super-admin')) {
            $adminUser->assignRole('super-admin');
        }

        // Create a demo association manager
        $managerUser = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Association Manager',
                'phone' => '0987654321',
                'password' => Hash::make('password'),
                'type' => 'association_manager',
            ]
        );

        // Assign association-manager role
        if (!$managerUser->hasRole('association-manager')) {
            $managerUser->assignRole('association-manager');
        }

        // Create a demo donor
        $donorUser = User::firstOrCreate(
            ['email' => 'donor@example.com'],
            [
                'name' => 'Demo Donor',
                'phone' => '1122334455',
                'password' => Hash::make('password'),
                'type' => 'donor',
            ]
        );

        // Assign donor role
        if (!$donorUser->hasRole('donor')) {
            $donorUser->assignRole('donor');
        }
    }
}
