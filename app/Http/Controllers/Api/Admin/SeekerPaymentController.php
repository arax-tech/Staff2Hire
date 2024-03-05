<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SeekerPayment;
use App\User;
use Auth;

class SeekerPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    
    public function index()
    {
        $payments = SeekerPayment::get();
        foreach ($payments as $key => $value)
        {
            $user = User::where('id', $value->seeker_id)->first();
            $payments[$key]->name = $user->name;
            $payments[$key]->email = $user->email;
        }
        return response()->json([
            'status' => 200,
            'message' => 'Payments...',
            'payments' => $payments,
        ],200);
    }

    public function single($id)
    {
        // dd($id);
        $payment = EmployerPayment::where('id', $id)->first();
        // dd($payment);
        error_reporting(0);
        foreach ($payment as $key => $value)
        {
            $user = User::where('id', $value->seeker_id)->first();
            $payment[$key]->name = $user->name;
            $payment[$key]->email = $user->email;
        }
        return response()->json([
            'status' => 200,
            'message' => 'Payment...',
            'payment' => $payment,
        ],200);
    }

    public function store(Request $request)
    {
        $payment = new SeekerPayment();
        $payment->seeker_id = $request->seeker_id;
        $payment->amount = $request->amount;
        $payment->type = $request->type;
        $payment->status = $request->status;
        $payment->save();

        // $employer = User::find($request->seeker_id);
        // $employer->payment_status = $request->status;
        // $employer->save();


        return response()->json([
            'status' => 201,
            'message' => 'Payment Created Successfully...'
        ],201);
    }


    public function update(Request $request, $id)
    {
        $payment = SeekerPayment::find($id);
        $payment->seeker_id = $request->seeker_id;
        $payment->amount = $request->amount;
        $payment->type = $request->type;
        $payment->status = $request->status;
        $payment->save();

        // $employer = User::find($request->user_id);
        // $employer->payment_status = $request->status;
        // $employer->save();

        
        return response()->json([
            'status' => 200,
            'message' => 'Payment Updated Successfully...'
        ],200);
    }


    public function delete($id)
    {
        $payment = SeekerPayment::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Payment Delete Successfully...'
        ],200);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
