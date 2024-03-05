<?php

namespace App\Http\Controllers\Api\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        error_reporting(0);
        $count = User::where('email', $request->email)->count();
        $role = User::where('email', $request->email)->first();    
        

        if ($count == 0)
        {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid Email OR Password...',
            ],401);
        }


        if ($role->role == "Seeker")
        {
            $credentials = $request->only('email', 'password');

            if ($token = $this->guard()->attempt($credentials)) {
                return $this->respondWithToken($token);
            }
            return response()->json([
                'status' => 401,
                'message' => 'Invalid Email OR Password...',
            ],401);
        }
        else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Only Seeker Can Login Here...',
            ],401);
        }
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 200,
            'message' => 'Logout Successfully...',
        ],200);
    }




    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'status'      =>     200,
                'message'   =>     'Login Successfully...',
                'token'          => $token,
                'token_type'     => 'bearer',
                'token_validity' => ($this->guard()->factory()->getTTL() * 60),
            ],200
        );
    }

    public function guard()
    {
        return Auth::guard();
    }
}
