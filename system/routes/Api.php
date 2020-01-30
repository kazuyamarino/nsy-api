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
	Route::get('', function() {
		Route::goto('ApiUser\controllerUser@show_data_users');
	});
	Route::post('', function() {
		Route::goto('ApiUser\controllerUser@add_data_users');
	});
	Route::post('/search', function() {
		Route::goto('ApiUser\controllerUser@search_data_users');
	});
	Route::get('/(:num)', function($id) {
		Route::goto('ApiUser\controllerUser@get_data_users', $id);
	});
	Route::post('/(:num)', function($id) {
		Route::goto('ApiUser\controllerUser@update_data_users', $id);
	});
	Route::delete('/(:num)', function($id) {
		Route::goto('ApiUser\controllerUser@delete_data_users', $id);
	});
});
