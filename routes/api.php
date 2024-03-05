<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Admin Routes

Route::group(['prefix' => 'admin','namespace' => 'Api\Admin', 'middleware' => 'api'], function () {
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');

    Route::get('profile', 'AdminController@profile');
    Route::post('profile/update', 'AdminController@updateProfile');
    Route::post('profile/update/image', 'AdminController@updateImage');

    Route::post('password/update', 'PasswordController@password');

    // Employer CRUD
    Route::get('employer', 'EmployerController@index');
    Route::post('employer/store', 'EmployerController@store');
    Route::post('employer/update/{id}', 'EmployerController@update');
    Route::get('employer/delete/{id}', 'EmployerController@delete');
    
    // Employer Payment CRUD
    Route::get('employer/payment', 'EmployerPaymentController@index');
    Route::post('employer/payment/store', 'EmployerPaymentController@store');
    Route::post('employer/payment/update/{id}', 'EmployerPaymentController@update');
    Route::get('employer/payment/delete/{id}', 'EmployerPaymentController@delete');
    
    
    // Seeker CRUD
    Route::get('seeker', 'SeekerController@index');
    Route::post('seeker/store', 'SeekerController@store');
    Route::post('seeker/update/{id}', 'SeekerController@update');
    Route::get('seeker/delete/{id}', 'SeekerController@delete');
    
    // Seeker Payment CRUD
    Route::get('seeker/payment', 'SeekerPaymentController@index');
    Route::post('seeker/payment/store', 'SeekerPaymentController@store');
    Route::post('seeker/payment/update/{id}', 'SeekerPaymentController@update');
    Route::get('seeker/payment/delete/{id}', 'SeekerPaymentController@delete');
    
    
    // Job CRUD
    Route::get('job', 'JobController@index');
    Route::post('job/store', 'JobController@store');
    Route::post('job/update/{id}', 'JobController@update');
    Route::get('job/delete/{id}', 'JobController@delete');
    
    
    Route::get('seeker/{id}', 'SeekerController@single');
    Route::get('employer/payment/{id}', 'EmployerPaymentController@single');
    Route::get('seeker/payment/{id}', 'SeekerPaymentController@single');
    Route::get('employer/{id}', 'EmployerController@single');
    Route::get('job/single/{id}', 'JobController@single');
});



Route::group(['prefix' => 'seeker','namespace' => 'Api\Seeker', 'middleware' => 'api'], function () {
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');

    Route::get('profile', 'SeekerController@profile');
    Route::post('profile/update', 'SeekerController@updateProfile');
    Route::post('profile/update/image', 'SeekerController@updateImage');

    Route::post('password/update', 'PasswordController@password');
    

    Route::get('job', 'JobController@index');

    // Apply for Job
    Route::get('apply', 'ApplyController@index');
    Route::post('apply/store', 'ApplyController@store');

    
});


Route::get('cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    die("Cash Cleard");
});