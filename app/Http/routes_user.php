<?php
// All routes in this (routes_user.php) file uses: 
// namespace    => app/Http/Controllers/User
// prefix       => /user/... 

Route::group(['middleware' => ['auth:user']], function ($router) {

    $router->get('/', ['uses' => 'IndexController@index'])->middleware('verified');
    $router->any('/account', ['uses' => 'IndexController@account'])->middleware('verified');
    $router->get('/accountsummary', ['uses' => 'IndexController@accountSummary'])->middleware('verified');
    // $router->any('/contact', ['uses' => 'IndexController@contact'])->middleware('verified');

    $router->any('/password/change', ['uses' => 'PasswordController@change']);

    // $router->get('/deal', ['uses' => 'DealController@index']);
    // $router->any('/deal/create', ['uses' => 'DealController@create']);    
    // $router->get('/deal/view/{id}/{page}', ['uses' => 'DealController@view']);
    // $router->get('/deal/modify/{id}/{page}', ['uses' => 'DealController@modify']);
    // $router->post('/deal/modify/post', ['uses' => 'DealController@modifyPost']);
    // $router->get('/deal/delete/{id}/{page}', ['uses' => 'DealController@delete']);
   
});

// Auth
// Route::any('register', ['uses' => 'AuthController@register']);
Route::get('register', ['uses' => 'AuthController@showRegistrationForm']);
Route::post('register', ['uses' => 'AuthController@register']);
//Route::any('login', ['uses' => 'AuthController@login']);
//Route::get('logout', ['uses' => 'AuthController@logout']);
Route::get('captcha/create', ['uses' => 'AuthController@createCaptcha']);

//
Route::any('login', ['uses' => 'ApiController@redirectLogin']);
Route::any('logout', ['uses' => 'ApiController@redirectLogout']);
Route::any('api/login', ['uses' => 'ApiController@login']);
Route::any('api/logout', ['uses' => 'ApiController@logout']);
//
Route::any('password/reset', ['uses' => 'PasswordController@reset']);
Route::any('password/reset/enter', ['uses' => 'PasswordController@resetEnter']);

Route::get('test/email', ['uses' => 'IndexController@testEmail']);
