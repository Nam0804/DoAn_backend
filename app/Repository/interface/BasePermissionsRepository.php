<?php

namespace App\Repository\interface;
interface BasePermissionsRepository
{
    public function index();
    public function showPermissionByRole($user_id);
}