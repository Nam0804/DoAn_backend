<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RollBackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tắt ràng buộc khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
        // Xóa tất cả các bản ghi trong bảng model_has_permissions
        DB::table('model_has_permissions')->truncate();
    
        // Xóa tất cả các bản ghi trong bảng model_has_roles
        DB::table('model_has_roles')->truncate();
    
        // Xóa tất cả các bản ghi trong bảng role_has_permissions
        DB::table('role_has_permissions')->truncate();
    
        // Xóa tất cả các bản ghi trong bảng permissions
        Permission::truncate();
    
        // Xóa tất cả các bản ghi trong bảng roles
        Role::truncate();
    
        // Bật lại ràng buộc khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}