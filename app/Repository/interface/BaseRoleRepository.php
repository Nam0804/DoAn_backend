<?php
namespace App\Repository\Interface;
interface BaseRoleRepository
{
    public function index();
    public function assignRole(array $data);
    public function createRole($role);
    public function updateRole($user_id, $role);
    public function showRole($user_id);
}