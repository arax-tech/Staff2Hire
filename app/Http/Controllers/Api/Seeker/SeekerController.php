<?php

namespace App\Http\Controllers\Api\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Auth;

class SeekerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function profile(Request $request)
    {
        $seeker = $this->guard()->user();
        $isEmpty = "";
        if(empty($seeker->image))
        {
            $isEmpty = "Yes";
        }
        else
        {
            $isEmpty = "No";
        }
        return response()->json([
            'status' => 200,
            'message' => 'seeker',
            'name' => $seeker->name,
            'email' => $seeker->email,
            'image' => $seeker->image,
            'isEmpty' => $isEmpty
        ], 200);
    }


    public function updateProfile(Request $request)
    {
        $seeker = $this->guard()->user();
        $seeker->name = $request->name;
        $seeker->email = $request->email;
        $seeker->save();
        return response()->json([
            'status' => 200,
            'message' => 'Profile Updated Successfully...'
        ], 200);
    }


    public function updateImage(Request $request)
    {
        $seeker = $this->guard()->user();

        if (File::exists($seeker->image)) {
            unlink($seeker->image);
        }
        
        $img = $request->image;
        $folderPath = "seeker/profile/"; //path location
        $filename = "profile-".time().".jpg";
	  	file_put_contents($folderPath . $filename,base64_decode($img));

        $seeker->image = "seeker/profile/".$filename;
        $seeker->save();

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
