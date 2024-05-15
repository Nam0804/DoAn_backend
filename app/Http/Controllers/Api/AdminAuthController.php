<?php

namespace App\Http\Controllers\Api;
use App\Traits\HttpResponses;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    use HttpResponses;
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Admin::where('email', $request->email)->first();
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
}
