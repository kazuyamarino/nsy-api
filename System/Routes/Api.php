<?php
// define API Routes.
// Format :
// Route::method('url', function() {
// 		Route::goto('namespace\class_controller@method');
// });
//
// Route::method('url/@id:num', function($id) {
// 		Route::goto('namespace\class_controller@method', $id);
// });
// Route method : get|post|put|patch|delete|head|options

// Api Route
Route::group('/users', function() {
	// Show all data users
	Route::get('/data', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'show_data_users']);

	// Search user data based on username
	Route::post('/data', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'search_data_users']);

	// Insert new user data
	Route::post('/insert', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'add_data_users']);

	// Get user data based on id
	Route::get('/(:num)', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'get_data_users']);

	// Update user data based on id
	Route::put('/(:num)', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'update_data_users']);

	// Delete user data based on id
	Route::delete('/(:num)', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'delete_data_users']);
});
