<?php

namespace App\Repository;

use App\Models\Admin;
use App\Models\User;
use App\Repository\interface\BaseRoleRepository;
use Spatie\Permission\Models\Role;

class RolesRepository implements BaseRoleRepository
{
    public function index()
    {
        return Role::all();
    }

    public function assignRoleUser($user_id, $type , $role,$guard=null)
    {
        if (!$guard) {
            $guard = 'admin';
        }
        $roleName =Role::findByName($role, $guard);
        $newAssignRole = Admin::where(['id'=>$user_id,'type'=> $type])->first();
        // foreach ($newAssignRole as $user) {
        //     $user->assignRole($roleName);
        // }
        return $newAssignRole->assignRole($roleName);
    }
    public function getAllRoles()
    {
        return Role::all();
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