<?php

namespace App\Repository;

use App\Models\Admin;
use App\Models\User;
use App\Repository\interface\BasePermissionsRepository;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsRepository implements BasePermissionsRepository
{
    public function index()
    {
        return Permission::all();
    }
    public function showPermissionByRole($id):\Illuminate\Support\Collection
    {
        $user = Admin::find($id);
        return $user->getAllPermissions();
    }
    public function updatePermissionByRole($role, array $permissions)
    {
        $role = Role::findByName($role);
        return $role->syncPermissions($permissions);
    }
}