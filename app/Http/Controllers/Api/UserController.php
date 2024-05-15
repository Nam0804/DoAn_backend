<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repository\UserRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;
    use HttpResponses;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function index()
    {
        $users = $this->userRepository->all();
        if($users){
            return $this->success(
                UserResource::collection($users),
                200,
                'All Users Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'No Product Found');
        }
    }
    public function create(Request $request)
    {
        $user = $this->userRepository->create($request->all());
        if($user){
            return $this->success(
                new UserResource($user),
                201,
                'User Created Successfully'
            );
        }else{
            return $this->error(null,500,'User Creation Failed');
        }
    }
    public function showUserById($id)
    {
        $user = $this->userRepository->show($id);
        if($user){
            return $this->success(
                new UserResource($user),
                200,
                'User Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'User Not Found');
        }
    }
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->update($request->all(),$id);
        if($user){
            return $this->success(
                new UserResource($user),
                200,
                'User Updated Successfully'
            );
        }else{
            return $this->error(null,500,'User Updation Failed');
        }
    }
    public function destroy($id)
    {
        $user = $this->userRepository->delete($id);
        if($user){
            return $this->success(
                new UserResource($user),
                200,
                'User Deleted Successfully'
            );
        }else{
            return $this->error(null,500,'User Deletion Failed');
        }
    }
    public function profile()
    {
        $user = auth('sanctum')->user();
        if($user){
            return $this->success([
                'data' => new UserResource($user),
                'message' => null,
            ], 200);
        }else{
            return $this->error(null, 'User not found', 400);
        }
    }
    public function profileUpdate(Request $request, $id)
    {
        $user = $this->userRepository->update($request->all(),$id);
        if($user){
            return $this->success(
                new UserResource($user),
                200,
                'User Updated Successfully'
            );
        }else{
            return $this->error(null,500,'User Updation Failed');
        }
    }
}
