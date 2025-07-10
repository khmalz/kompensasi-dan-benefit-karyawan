<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $adminPermissions = [
            'benefit_access',
            'benefit_manage',
            'employee_access',
            'employee_manage',
            'benefit_response_manage'
        ];

        $employeePermissions = [
            'benefit_access',
            'benefit_manage',
        ];

        $allPermission = array_unique(array_merge($employeePermissions, $adminPermissions));

        foreach ($allPermission as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        $role = Role::create(['name' => 'admin']);
        foreach ($adminPermissions as $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::create(['name' => 'employee']);
        foreach ($employeePermissions as $permission) {
            $role->givePermissionTo($permission);
        }
    }
}
