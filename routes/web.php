<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 
	// function () { return view('party.index');}
	['uses' => 'PartyController@index', 'as' => 'company']
);

/*// This is returning the view party.show
Route::get('/blog/show/', function () {
	return view('party.show');
});*/

Route::get('/party/{company}', 
	['uses' => 'PartyController@show', 'as' => 'party.show']
);

Route::post('party/{company}/comments',
	['uses' => 'CommentsController@store', 'as' => 'party.comments']
);

Route::get('/category/{category}', 
	['uses' => 'PartyController@category', 'as' => 'category']
);

Route::get('/user/{user}', 
	['uses' => 'PartyController@user', 'as' => 'user']
);

Route::get('/tag/{tag}', 
	['uses' => 'PartyController@tag', 'as' => 'tag']
);
Auth::routes();
// change this to admin/ at some point

Route::group(['prefix' => 'admin', 'middleware' => ['role:superadministrator|administrator|user']], function() {
	// Route::resource('/admin/tags', 'Admin\TagController', ['as' => 'admin']);

	// Route::get('/admin/users/confirm/{user}', [
	//     'uses' => 'Admin\UsersController@confirm',
	//     'as' => 'admin.users.confirm'
	// ]);

	// Route::resource('/admin/users', 'Admin\UsersController');

	Route::resource('tags', 'Admin\TagController', ['as' => 'admin']);

	Route::get('users/confirm/{user}', [
	    'uses' => 'Admin\UsersController@confirm',
	    'as' => 'admin.users.confirm'
	]);

	Route::resource('/users', 'Admin\UsersController', ['as' => 'admin']);

	Route::resource('/permissions', 'Admin\PermissionController', ['as' => 'admin'], ['except' => 'destroy']);

	Route::resource('/roles', 'Admin\RoleController', ['as' => 'admin'], ['except' => 'destroy']);
});


Route::get('/home', 'Admin\HomeController@index')->name('home');
Route::get('/edit-account', 'Admin\HomeController@edit');
Route::put('/edit-account', 'Admin\HomeController@update');


Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

//Route::get('/logout', 'Auth\LoginController@logout');

/*Route::get('/admin/party/index', 
	['uses' => 'Admin\PartyController@index', 'as' => 'admin.party.index']
);
Route::get('/admin/party/create', 
	['uses' => 'Admin\PartyController@create', 'as' => 'admin.party.create']
);*/

// TODO: move all the admin routes here inside the prefix

/*Route::prefix('admin')->group(function(){
	// Move all the admin routes here
	//https://youtu.be/wD3_QlNwAog?t=1108
});*/


// for some reason {company does not work}
Route::put('/admin/party/restore/{party}', [
    'uses' => 'Admin\PartyController@restore',
    'as'   => 'admin.party.restore'
]);
// for some reason force-destroy did not work
Route::delete('/admin/party/force_destroy/{party}', [
    'uses' => 'Admin\PartyController@forceDestroy',
    'as'   => 'admin.party.force_destroy'
]);

// TODO: admin needs to update the route, was messing with the frontend party.show
//Route::resource('/admin/party', 'Admin\PartyController');
Route::resource('/admin/party', 'Admin\PartyController', ['as' => 'admin']);

Route::resource('/admin/categories', 'Admin\CategoriesController', ['as' => 'admin']);
/*Route::get('/admin/party/index', 'Admin\PartyController');
Route::get('/admin/party/create', 'Admin\PartyController@create');*/


Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback','Auth\LoginController@handleProviderCallback');


