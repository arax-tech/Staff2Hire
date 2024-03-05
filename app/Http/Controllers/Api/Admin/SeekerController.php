<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\User;
use Auth;

class SeekerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    
    public function index()
    {
        $seekers = User::where('role', 'Seeker')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Seekers...',
            'seekers' => $seekers,
        ],200);
    }

    public function single($id)
    {
        $seeker = User::where(['role' => 'Seeker', 'id' => $id])->first();
        return response()->json([
            'status' => 200,
            'message' => 'Seeker...',
            'seeker' => $seeker,
        ],200);
    }

    public function store(Request $request)
    {
        $check = User::where('email', $request->email)->count();
        if ($check > 0)
        {
            return response()->json([
                'status' => 422,
                'message' => 'Email is already taken, Please use another email...'
            ],422);    
        }
        

        $seeker = new User();
        $seeker->name = $request->name;
        $seeker->email = $request->email;
        $seeker->password = Hash::make($request->password);
        $seeker->gender = $request->gender;
        $seeker->phone = $request->phone;
        $seeker->country = $request->country;
        $seeker->state = $request->state;


  
        
        if ($request->resume)
        {
            $resume = $request->resume;
            $folderPath = "seeker/resume/"; //path location
            $resumeName = "resume-".time().".jpg";
            file_put_contents($folderPath . $resumeName,base64_decode($resume));

            $seeker->resume = $folderPath.$resumeName;
        }
        else
        {
            $seeker->resume = '';
        }
        
        if ($request->profile)
        {
            $profile = $request->profile;
            $folderPath1 = "seeker/profile/"; //path location
            $profileName = "profile-".time().".jpg";
            file_put_contents($folderPath1 . $profileName,base64_decode($profile));

            $seeker->image = $folderPath1.$profileName;
        }
        else
        {
            $seeker->image = '';
        }

        

        $seeker->about = $request->about;
        $seeker->status = $request->status;
        $seeker->payment_status = $request->payment_status;

        $seeker->is_verified = 1;
        $seeker->verification_code = rand(3200,4800);
        $seeker->role = "Seeker";

        $seeker->save();


        
        return response()->json([
            'status' => 201,
            'message' => 'Seeker Created Successfully...'
        ],201);
    }


    public function update(Request $request, $id)
    {
      
        

        $seeker = User::find($id);
        $seeker->name = $request->name;
        $seeker->email = $request->email;
        $seeker->password = Hash::make($request->password);
        $seeker->gender = $request->gender;
        $seeker->phone = $request->phone;
        $seeker->country = $request->country;
        $seeker->state = $request->state;
        
        
        if ($request->resume)
        {
            $resume = $request->resume;
            $folderPath = "seeker/resume/"; //path location
            $resumeName = "resume-".time().".jpg";
            file_put_contents($folderPath . $resumeName,base64_decode($resume));

            $seeker->resume = $folderPath.$resumeName;
        }
        else
        {
            $seeker->resume = $seeker->resume;
        }
        
        if ($request->profile)
        {
            $profile = $request->profile;
            $folderPath1 = "seeker/profile/"; //path location
            $profileName = "profile-".time().".jpg";
            file_put_contents($folderPath1 . $profileName,base64_decode($profile));

            $seeker->image = $folderPath1.$profileName;
        }
        else
        {
            $seeker->image = $seeker->image;
        }


        $seeker->about = $request->about;
        $seeker->status = $request->status;
        $seeker->payment_status = $request->payment_status;
        $seeker->save();


        
        return response()->json([
            'status' => 200,
            'message' => 'Seeker Updated Successfully...'
        ],200);
    }


    public function delete($id)
    {
        $seeker = User::find($id);
        if (File::exists($seeker->resume)) {
            unlink($seeker->resume);
        }

        if (File::exists($seeker->image)) {
            unlink($seeker->image);
        }

        $seeker->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Seeker Delete Successfully...'
        ],200);
    }
    
    public function guard()
    {
        return Auth::guard();
    }
}
