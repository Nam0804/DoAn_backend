<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Admin;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;
    public function login(Request $request)
    {
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password
        ];
        if (Auth::guard('web')->attempt($credentials)) {
            $user = User::where('phone', $request->phone)->first();
            $token = $user->createToken('login_token')->plainTextToken;
            return $this->success(
                [
                    'user' => $user,
                    'token' => $token
                ],
                200,
                'User Logged In Successfully'
            );
        } else {
            return $this->error(null, 404, 'User Not Logged In');
        }
    }
    public function logout(Request $request)
    {
        if ($request->user()) {
            try {
                $request->user()->currentAccessToken()->delete();
                return $this->success(null, 200, 'User Logged Out Successfully');
            } catch (\Exception $e) {
                return $this->error(null, 500, 'Error Logging Out');
            }
        } else {
            return $this->error(null, 401, 'User Not Logged In');
        }   
    }
    public function register(StoreUserRequest $request)
    {
        //dd($request->all());
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'user_agent' => $request->user_agent,
            //'type' => $request->type,
        ]);
        $token = $user->createToken('register_token')->plainTextToken;
        if ($user) {
            return $this->success(
                [
                    'user' => $user,
                    'token' => $token
                ],
                201,
                'User Created Successfully'
            );
        } else {
            return $this->error(null, 404, 'User Not Created');
        }
    }
}
