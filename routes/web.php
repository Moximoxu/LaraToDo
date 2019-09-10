<?php

use LaraToDo\User;
use Illuminate\Support\Facades\Auth;
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
Route::group(['middleware' => 'LaraToDo\Http\Middleware\AdminMiddleware'], function(){
	Route::match(['get', 'post'], '/admin', function(){
		return view('admin');
	});

	Route::match(['get', 'post'], '/', function(){
		Auth::logout();
		return view('welcome');
	});

	Route::match(['get', 'post'], '/admin/', 'AdminController@show');
	Route::match(['get', 'post'], '/admin/edit', 'EditProfileController@edituser');

	Route::match(['get', 'delete'], '/admin/{user}', 'AdminController@destroy');

	Route::match(['get', 'post'], '/logout', 'Auth\LoginController@logout')->name('auth.logout');
});

Route::group(['middleware' => 'LaraToDo\Http\Middleware\MemberMiddleware'], function(){
	Route::match(['get', 'post'], '/index', 'Auth\LoginController@index');

	Route::match(['get', 'post'], '/tasks/{task}/done', 'TaskController@done');
	Route::match(['get', 'post'], '/tasks/{task}/undone', 'TaskController@undone');

	Route::match(['get', 'delete'], '/tasks/{task}', 'TaskController@destroy');

	Route::match(['get', 'post'], '/tasks/', 'TaskController@show');
	Route::match(['get', 'post'], '/tasks', 'TaskController@store');

	Route::match(['get', 'put'], '/tasks', 'TaskController@store');

	Route::match(['get', 'post'], '/user/edit', 'EditProfileController@edituser');

	Route::match(['get', 'post'], '/edit', function(){
			return view('edituser');
	});

	Route::match(['get', 'post'], 'resetpassword', function(){
			return view('auth/passwords/reset');
	});

	Route::match(['get', 'post'], '/resetpass', 'Auth\ResetPasswordController@reset');

});

	Route::get('/', function(){
		Auth::logout();
		return view('welcome');
	});

	Route::post('/checklogin', 'Auth\LoginController@checklogin')->name('checklogin');
	
	Route::get('/about', function () {
	    return view('about');
	});

	Route::get('register', function(){
		return view('auth/register');
	});
	Route::post('/register/create', 'Auth\RegisterController@create');
	Route::post('/register/', 'Auth\RegisterController@validator');

	Route::post('/resetpass', 'Auth\ResetPasswordController@reset');

	Auth::routes(['verify' => true]);

	Route::get('verify', function(){
		return view('auth/verify');
	});