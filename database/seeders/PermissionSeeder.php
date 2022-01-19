<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $microPermissions = ['access publishers orders' , 'access publishers deliveries' , 'access publishers returns' , 'access suppliers orders', 'access suppliers deliveries' , 'access suppliers returns', 'settings'];

        $modules = ['locations', 'warehouses', 'publishers', 'suppliers', 'schools', 'school orders',  'books', 'bundles', 'sales'  ];

        // $accessPoints = ['access', 'create', 'edit', 'delete' , 'export'];
        $accessPoints = ['access', 'create', 'edit' ];
        // create permissions
        foreach ($modules as $key => $module) {
            foreach ($accessPoints as $key => $points) {
                Permission::create(['name' => "{$points} {$module}"]);
            }
        }

        foreach ($microPermissions as $key => $permission) {
            Permission::create(['name' => $permission]);
        }

        // admin role
        $role = Role::create(['name' => 'Super-Admin']);
    }
}
