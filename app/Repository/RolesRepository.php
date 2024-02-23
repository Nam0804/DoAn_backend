<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Interface\BaseRoleRepository;
use Spatie\Permission\Models\Role;

class RolesRepository implements BaseRoleRepository
{
    public function index()
    {
        return Role::all();
    }

    public function assignRole(array $data)
    {
        $user = User::find($data['user_id']);
        return $user->assignRole($data['role']);
    }

    public function createRole($role)
    {
        return Role::create(['name' => $role]);
    }

    public function updateRole($user_id, $role)
    {
        $user = User::find($user_id);
        return $user->syncRoles($role);
    }

    public function showRole($user_id)
    {
        $user = User::find($user_id);
        return $user->getRoleNames();
    }
}