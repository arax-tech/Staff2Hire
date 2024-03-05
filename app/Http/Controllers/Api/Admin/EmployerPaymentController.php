<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EmployerPayment;
use App\User;
use Auth;

class EmployerPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    
    public function index()
    {
        $payments = EmployerPayment::get();
        error_reporting(0);
        foreach ($payments as $key => $value)
        {
            $user = User::where('id', $value->employer_id)->first();
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
            $user = User::where('id', $value->employer_id)->first();
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
        $payment = new EmployerPayment();
        $payment->employer_id = $request->employer_id;
        $payment->amount = $request->amount;
        $payment->type = $request->type;
        $payment->status = $request->status;
        $payment->save();

        // $employer = User::find($request->user_id);
        // $employer->payment_status = $request->status;
        // $employer->save();


        return response()->json([
            'status' => 201,
            'message' => 'Payment Created Successfully...'
        ],201);
    }


    public function update(Request $request, $id)
    {
        $payment = EmployerPayment::find($id);
        $payment->employer_id = $request->employer_id;
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
        $payment = EmployerPayment::find($id)->delete();
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
