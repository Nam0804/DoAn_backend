<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run():void
    {
        Permission::create(['name' => 'create_user','guard_name'=>'admin']);
        Permission::create(['name' => 'edit_user','guard_name'=>'admin']);
        Permission::create(['name' => 'delete_user','guard_name'=>'admin']);
        Permission::create(['name' => 'view_user','guard_name'=>'admin']);

        Permission::create(['name' => 'create_blog','guard_name'=>'admin']);
        Permission::create(['name' => 'edit_blog','guard_name'=>'admin']);
        Permission::create(['name' => 'delete_blog','guard_name'=>'admin']);
        Permission::create(['name' => 'view_blog','guard_name'=>'admin']);

        Permission::create(['name' => 'create_product','guard_name'=>'admin']);
        Permission::create(['name' => 'edit_product','guard_name'=>'admin']);
        Permission::create(['name' => 'delete_product','guard_name'=>'admin']);
        Permission::create(['name' => 'view_product','guard_name'=>'admin']);

        $adminRole = Role::create(['name' => 'admin','guard_name'=>'admin']);
        $managerRole = Role::create(['name' => 'manager','guard_name'=>'admin']);
        $employeeRole = Role::create(['name' => 'employee','guard_name'=>'admin']);

        $adminRole->givePermissionTo([
            'create_user',
            'edit_user',
            'delete_user',
            'view_user',
            'create_blog',
            'edit_blog',
            'delete_blog',
            'view_blog',
            'create_product',
            'edit_product',
            'delete_product',
            'view_product',
        ]);
        $managerRole->givePermissionTo([
            'create_user',
            'edit_user',
            'delete_user',
            'view_user',
            'create_blog',
            'edit_blog',
            'delete_blog',
            'view_blog',
            'create_product',
            'edit_product',
            'delete_product',
            'view_product',
        ]);
        $employeeRole->givePermissionTo([
            'view_user',
            'create_blog',
            'edit_blog',
            'delete_blog',
            'view_blog',
            'create_product',
            'edit_product',
            'delete_product',
            'view_product',
        ]);
    }
}
