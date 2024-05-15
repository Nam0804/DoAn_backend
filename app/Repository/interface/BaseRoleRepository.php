<?php
namespace App\Repository\Interface;
interface BaseRoleRepository
{
    public function index();
    public function assignRoleUser($user_id,$type, $role,$guard);
    public function getAllRoles();
    public function createRole($role);
    public function updateRole($user_id, $role);
    public function showRole($user_id);
}