<?php

use System\Middlewares\BeforeLayer;

// Define API Routes
// Format :
// Route::method('url', function() {
//      Route::goto('namespace\class_controller@method');
// });
//
// Route::method('url/@id:num', function($id) {
//      Route::goto('namespace\class_controller@method', $id);
// });
// Route method : get|post|put|patch|delete|head|options

// Login endpoint
Route::post('/login', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'login']);

// Refresh token endpoint
Route::post('/refresh-token', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'refresh_token']);

// Api Route
Route::group('/users', function() {
    $middleware = [new BeforeLayer()];

    // Show all data users
    Route::get('/data', function () use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'show_data_users']);
    });

    // Search user data based on username
    Route::post('/data', function () use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'search_data_users']);
    });

    // Insert new user data
    Route::post('/insert', function () use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'add_data_users']);
    });

    // Get user data based on id
    Route::get('/(:num)', function ($id) use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'get_data_users'], $id);
    });

    // Update user data based on id
    Route::put('/(:num)', function ($id) use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'update_data_users'], $id);
    });

    // Delete user data based on id
    Route::delete('/(:num)', function ($id) use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'delete_data_users'], $id);
    });
});
