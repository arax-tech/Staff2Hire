<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function profile(Request $request)
    {
        $admin = $this->guard()->user();
        $isEmpty = "";
        if(empty($admin->image))
        {
            $isEmpty = "Yes";
        }
        else
        {
            $isEmpty = "No";
        }
        return response()->json([
            'status' => 200,
            'message' => 'Admin',
            'name' => $admin->name,
            'email' => $admin->email,
            'image' => $admin->image,
            'isEmpty' => $isEmpty
        ], 200);
    }


    public function updateProfile(Request $request)
    {
        $admin = $this->guard()->user();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();
        return response()->json([
            'status' => 200,
            'message' => 'Profile Updated Successfully...'
        ], 200);
    }


    public function updateImage(Request $request)
    {
        $admin = $this->guard()->user();

        if (File::exists($admin->image)) {
            unlink($admin->image);
        }
        
        $img = $request->image;
        $folderPath = "admin/profile/"; //path location
        $filename = "profile-".time().".jpg";
	  	file_put_contents($folderPath . $filename,base64_decode($img));

        $admin->image = "admin/profile/".$filename;
        $admin->save();

        return response()->json([
            'status' => 200,
            'message' => 'Profile Image Successfully...'
        ], 200);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
