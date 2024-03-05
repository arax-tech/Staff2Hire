<?php

namespace App\Http\Controllers\Api\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Job;
use App\User;
use Auth;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    
    public function index(Request $request)
    {
        
        $jobs = Job::where('category', $request->category)->get();
        
        return response()->json([
            'status' => 200,
            'jobs' => $jobs,
        ],200);
    }

    public function single($id)
    {
        $job = Job::find($id);
        error_reporting(0);
        $user = User::find($job->employer_id);
        $job->name = $user->name;
        $job->email = $user->email;
        
        return response()->json([
            'status' => 200,
            'message' => 'job...',
            'job' => $job,
        ],200);
    }

    public function store(Request $request)
    {
        $job = new Job();
        $job->employer_id = $request->employer_id;
        $job->title = $request->title;
        $job->category = $request->category;
        $job->company_name = $request->company_name;
        $job->location = $request->location;
        $job->type = $request->type;
        $job->salery = $request->salery;
        $job->commission = $request->commission;
        $job->minimum_age = $request->minimum_age;
        $job->experience = $request->experience;
        $job->experience_required = $request->experience_required;
        $job->education = $request->education;
        $job->description = $request->description;
        $job->save();


        return response()->json([
            'status' => 201,
            'message' => 'Job Created Successfully...'
        ],201);
    }


    public function update(Request $request, $id)
    {
        $job = Job::find($id);
        $job->employer_id = $request->employer_id;
        $job->title = $request->title;
        $job->category = $request->category;
        $job->company_name = $request->company_name;
        $job->location = $request->location;
        $job->type = $request->type;
        $job->salery = $request->salery;
        $job->commission = $request->commission;
        $job->minimum_age = $request->minimum_age;
        $job->experience = $request->experience;
        $job->experience_required = $request->experience_required;
        $job->education = $request->education;
        $job->description = $request->description;
        $job->save();


        return response()->json([
            'status' => 200,
            'message' => 'Job Updated Successfully...'
        ],201);
    }


    public function delete($id)
    {
        $Job = Job::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Job Delete Successfully...'
        ],200);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
