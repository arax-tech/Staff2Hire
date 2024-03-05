<?php

namespace App\Http\Controllers\Api\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function password(Request $request)
    {
        
        if (!(Hash::check($request->current_password,$this->guard()->user()->password)))
        {
            return response()->json([
                'status' => 422,
                'message' => 'Current Password is Incorrect...'
            ],422);
        }

        if (strcmp($request->current_password, $request->new_password)==0)
        {
            return response()->json([
                'status' => 422,
                'message' => 'Your New Password Can not be Same...'
            ],422);
        }

        $user = $this->guard()->user();
        $user->password = bcrypt($request->new_password);
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => 'Password Update Successfully...'
        ],200);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
