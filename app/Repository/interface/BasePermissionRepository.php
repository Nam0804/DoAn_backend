<?php

namespace App\Repository\Interface;
interface BasePermissionsRepository
{
    public function index();
    public function showPermissionByRole($user_id);
}