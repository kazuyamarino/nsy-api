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
	Route::get('', 'ApiUser\controllerUser@show_data_users');

	// Insert new user data
	Route::post('', 'ApiUser\controllerUser@add_data_users');

	// Search user data based on username
	Route::post('/search', 'ApiUser\controllerUser@search_data_users');

	// Get user data based on id
	Route::get('/(:num)', 'ApiUser\controllerUser@get_data_users');

	// Update user data based on id
	Route::post('/(:num)', 'ApiUser\controllerUser@update_data_users');

	// Delete user data based on id
	Route::delete('/(:num)', 'ApiUser\controllerUser@delete_data_users');
});
