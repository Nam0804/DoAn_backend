<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repository\PermissionsRepository;
use App\Repository\RolesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class RolesAndPermissionsController extends Controller
{
    private PermissionsRepository $permissionsRepository;
    private RolesRepository $rolesRepository;

    function __construct(PermissionsRepository $permissionsRepository,
        RolesRepository $rolesRepository)
    {
        $this->permissionsRepository = $permissionsRepository;
        $this->rolesRepository = $rolesRepository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $permissions = $this->permissionsRepository->index();
            $role = $this->rolesRepository->index();
            $statusCode = 200;
        } catch (\Exception $e) {
            $permissions = null;
            $role = null;
            $statusCode = 500;
        }

        return response()->json([
            'permissions' => $permissions,
            'role' => $role
        ], $statusCode);
    }
    //viết hàm gán quyền cho tài khoản admin
    public function assignRoleForAdmin()
    {
        try{
            $users = Admin::where('type', 0)->get();
            if ($users->isEmpty()) {
                throw new \Exception('No users found with type 0');
            }
            foreach ($users as $user) {
                $user->assignRole('admin');
            }
            //$this->rolesRepository->assignRole(0,'admin','admin');
            $message = 'Role assigned successfully';
            $statusCode = 200;
        } catch (\Exception $e) {
            dd($e->getMessage());
            $message = 'Role assigned failed';
            $statusCode = 500;
        }
        return response()->json([
            'message' => $message,
        ], $statusCode);
    }
    public function assignRole($user_id,$user_type): \Illuminate\Http\JsonResponse
    {
        try {
            if($user_type == 0){
                $this->rolesRepository->assignRoleUser($user_id ,0,'admin');
            }
            if($user_type == 1){
                $this->rolesRepository->assignRoleUser($user_id,1,'manager');
            }
            if($user_type == 2){
                $this->rolesRepository->assignRoleUser($user_id,2,'employee');
            }
            $message = 'Role assigned successfully';
            $statusCode = 200;
        } catch (\Exception $e) {
            $role = null;
            $statusCode = 500;
            $message = 'Role assigned failed';
        }
        return response()->json([
            //            'role' => $role,
            'message' => $message,
        ], $statusCode);
    }

    public function showRole($request): \Illuminate\Http\JsonResponse
    {
        try {
            $roleByUser = $this->rolesRepository->showRole($request->user_id);
            $statusCode = 200;
        } catch (\Exception $e) {
            $roleByUser = null;
            $statusCode = 500;
        }
        $roleByUser = $this->rolesRepository->showRole($request->user);
        return response()->json(['roleByUser' => $roleByUser], $statusCode);
    }
    public function showPermissions(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $permissionList = $this->permissionsRepository->showPermissionByRole($request->id);
            $statusCode = 200;
        } catch (\Exception $e) {
            $permissionList = null;
            $statusCode = 500;
        }
        return response()->json(['permissionsByRole' => $permissionList], $statusCode);
    }

    public function createNewRole(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->rolesRepository->createRole($request->role);
            $message = 'Role created successfully';
            $statusCode = 200;
        } catch (\Exception $e) {
            $message = 'Error creating new role';
            $statusCode = 500;
        }

        return response()->json([
            'message' => $message,
        ], $statusCode);
    }

    public function editRole(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->rolesRepository->updateRole($request->user_id, $request->role);
            $role = $request->user->hasRole();
            $message = 'Role updated successfully';
            $statusCode = 200;
        } catch (\Exception $e) {
            $role = null;
            $message = 'Error updating role';
            $statusCode = 500;
        }

        return response()->json([
            'message' => $message,
            'role' => $role,
        ], $statusCode);
    }

    public function updatePermissions(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->permissionsRepository->updatePermissionByRole($request->role, $request->permissions);
            $message = 'permissions updated successfully';
            $statusCode = 200;
        } catch (\Exception $e) {
            $message = 'Error updating permissions';
            $statusCode = 500;
        }

        return response()->json([
            'message' => $message,
        ], $statusCode);
    }
}