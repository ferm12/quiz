<?php
// All roures in this (routes_admin.php) file uses:
// namespace    => app/Http/Controllers/Admin
// prefix       => /admin/...

Route::group(['middleware' => ['auth:admin']], function ($router) {
    
    $router->get('/', ['uses' => 'IndexController@index']);
    $router->get('/import', ['uses' => 'IndexController@import']);
    $router->any('/config', ['uses' => 'IndexController@config']);   

    $router->any('/password/change', ['uses' => 'PasswordController@change']);

    // /admin/customers/ 
    $router->any('/customers', ['uses' => 'CustomerController@index']);
    $router->get('/customers/modify/{id}/{page}', ['uses' => 'CustomerController@modify']);
    $router->post('/customers/modify/post', ['uses' => 'CustomerController@modifyPost']);
    $router->get('/customers/delete/{id}/{page}', ['uses' => 'CustomerController@delete']);
    $router->any('/customers/resetpassword/{id}', ['uses' => 'CustomerController@resetPassword']);
    // $router->get('/customers/export/csv/', ['uses' => 'CustomerController@exportCSV']);

    // /admin/deals/ 
    // $router->any('/deals', ['uses' => 'DealController@index']);
    // $router->get('/deals/modify/{id}/{page}', ['uses' => 'DealController@modify']);
    // $router->post('/deals/modify/post', ['uses' => 'DealController@modifyPost']);
    // $router->get('/deals/delete/{id}/{page}', ['uses' => 'DealController@delete']);
    // $router->get('/deals/export/csv/', ['uses' => 'DealController@exportCSV']);
    // $router->any('/macids', ['uses' => 'MacidController@index']);
    // $router->get('/macids/modify/{id}/{page}', ['uses' => 'MacidController@modify']);
    // $router->post('/macids/modify/post', ['uses' => 'MacidController@modifyPost']);
    // $router->get('/macids/delete/{id}/{page}', ['uses' => 'MacidController@delete']);
    // $router->get('/deals/export/csv/', ['uses' => 'DealController@exportCSV']);


    // /admin/users/ 
    $router->any('/users', ['uses' => 'UserController@index']);
    $router->any('/users/create', ['uses' => 'UserController@create']);
    $router->get('/users/modify/{id}/{page}', ['uses' => 'UserController@modify']);
    $router->post('/users/modify/post', ['uses' => 'UserController@modifyPost']);
    $router->get('/users/delete/{id}/{page}', ['uses' => 'UserController@delete']);

    // /admin/permissions/ 
    $router->any('/permissions', ['uses' => 'PermissionController@index']);
    $router->any('/permissions/create', ['uses' => 'PermissionController@create']);
    $router->get('/permissions/modify/{id}/{page}', ['uses' => 'PermissionController@modify']);
    $router->post('/permissions/modify/post', ['uses' => 'PermissionController@modifyPost']);
    $router->get('/permissions/delete/{id}/{page}', ['uses' => 'PermissionController@delete']);

});

// Auth
Route::any('login', ['uses' => 'AuthController@login']);
//Route::any('register', ['uses' => 'AuthController@register']);
Route::get('logout', ['uses' => 'AuthController@logout']);
Route::get('captcha/create', ['uses' => 'AuthController@createCaptcha']);
Route::any('password/reset', ['uses' => 'PasswordController@reset']);
Route::any('password/reset/enter', ['uses' => 'PasswordController@resetEnter']);
