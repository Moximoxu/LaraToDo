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

Route::group(['middleware' => 'auth'], function(){
	if(Auth::user() == User::where('roles', 'admin')){
		Route::get('/admin/', 'AdminController@show');
		Route::post('/admin/edit', 'EditProfileController@edituser');
		Route::get('/admin', function(){
			return view('admin');
		});
		Route::post('/checklogin', 'Auth\LoginController@checklogin')->name('checklogin');
		Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');

		Route::get('login', function(){
			return view('auth/login');
		});

		Route::get('/', function(){
			Auth::logout();
			return view('welcome');
		});
	}
	elseif(Auth::user() == User::where('roles', 'user')){
		Route::post('/checklogin', 'Auth\LoginController@checklogin')->name('checklogin');
		Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');

		Route::get('login', function(){
			return view('auth/login');
		});

		Route::get('/', function(){
			Auth::logout();
			return view('welcome');
		});

		Route::get('/index', 'Auth\LoginController@index');
		Route::post('/tasks/{task}/done', 'TaskController@done');
		Route::post('/tasks/{task}/undone', 'TaskController@undone');
		Route::delete('/tasks/{task}', 'TaskController@destroy');

		Route::get('/tasks/', 'TaskController@show');
		Route::post('/tasks', 'TaskController@store');

		Route::put('/tasks/', 'TaskController@update');

		Route::post('/user/edit', 'EditProfileController@edituser');

		Route::get('/edit', function(){
			return view('edituser');
		});

		Route::get('resetpassword', function(){
			return view('auth/passwords/reset');
		});

		Route::post('/resetpass', 'Auth\ResetPasswordController@reset');
	}

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