<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Home
Route::get('/', function () {

    return redirect('/user');
    
});

// Service
//Route::any('/service/report', ['uses' => 'ServiceController@report']);

///////////////////////////////////////////////////////////////////////////
//
Route::group(['middleware' => ['web']], function () {

	//
    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {

		require __DIR__.'/routes_user.php';
    });

    //
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

 		require __DIR__.'/routes_admin.php'; 
 		      
    });

});

// Auth::routes(['verify' => true]);

// Authentication Routes...
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Rooutes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
// Email  Verification Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend/{id}', 'Auth\VerificationController@resend')->name('verification.resend');
