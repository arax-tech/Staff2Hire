<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\User;
use Auth;

class EmployerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    
    public function single($id)
    {
        $employer = User::where(['role' => 'Employer', 'id' => $id])->first();
        return response()->json([
            'status' => 200,
            'message' => 'Employer...',
            'employer' => $employer,
        ],200);
    }
    
    public function index()
    {
        $employers = User::where('role', 'Employer')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Employers...',
            'employers' => $employers,
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
        

        $employer = new User();
        $employer->name = $request->name;
        $employer->email = $request->email;
        $employer->password = Hash::make($request->password);
        $employer->gender = $request->gender;
        $employer->phone = $request->phone;
        $employer->company_name = $request->company_name;
        $employer->company_website = $request->company_website;
        
        
        if ($request->company_logo)
        {

            $company_logo = $request->company_logo;
            $folderPath = "employer/company/logo/"; //path location
            $logoName = "logo-".time().".jpg";
            file_put_contents($folderPath . $logoName,base64_decode($company_logo));

            $employer->company_logo = $folderPath.$logoName;
        }
        else
        {
            $employer->company_logo = "";
        }

        if ($request->latter_head)
        {
            $latter_head = $request->latter_head;
            $folderPath = "employer/company/latter-head/"; //path location
            $latterHeadName = "latter-head-".time().".jpg";
            file_put_contents($folderPath . $latterHeadName,base64_decode($latter_head));

            $employer->latter_head = $folderPath.$latterHeadName;
        }
        else
        {
            $employer->latter_head = "";
        }


        $employer->about = $request->about;
        $employer->tax_id = $request->tax_id;
        $employer->status = $request->status;
        $employer->payment_status = $request->payment_status;

        $employer->is_verified = 1;
        $employer->verification_code = rand(3200,4800);
        $employer->role = "Employer";

        $employer->save();


        
        return response()->json([
            'status' => 201,
            'message' => 'Employer Created Successfully...'
        ],201);
    }


    public function update(Request $request, $id)
    {
        $employer = User::find($id);
        $employer->name = $request->name;
        $employer->email = $request->email;
        if ($request->password)
        {
            $employer->password = Hash::make($request->password);
        }
        $employer->gender = $request->gender;
        $employer->phone = $request->phone;
        $employer->company_name = $request->company_name;
        $employer->company_website = $request->company_website;
        
        
        if ($request->company_logo)
        {

            $company_logo = $request->company_logo;
            $folderPath = "employer/company/logo/"; //path location
            $logoName = "logo-".time().".jpg";
            file_put_contents($folderPath . $logoName,base64_decode($company_logo));

            $employer->company_logo = $folderPath.$logoName;
        }
        else
        {
            $employer->company_logo = $employer->company_logo;
        }

        if ($request->latter_head)
        {
            $latter_head = $request->latter_head;
            $folderPath = "employer/company/latter-head/"; //path location
            $latterHeadName = "latter-head-".time().".jpg";
            file_put_contents($folderPath . $latterHeadName,base64_decode($latter_head));

            $employer->latter_head = $folderPath.$latterHeadName;
        }
        else
        {
            $employer->latter_head = $employer->latter_head;
        }


        $employer->about = $request->about;
        $employer->tax_id = $request->tax_id;
        $employer->save();


        
        return response()->json([
            'status' => 200,
            'message' => 'Employer Updated Successfully...'
        ],200);
    }


    public function delete($id)
    {
        $employer = User::find($id);
        if (File::exists($employer->company_logo)) {
            unlink($employer->company_logo);
        }

        if (File::exists($employer->latter_head)) {
            unlink($employer->latter_head);
        }

        $employer->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Employer Delete Successfully...'
        ],200);
    }
    
    public function guard()
    {
        return Auth::guard();
    }
}
