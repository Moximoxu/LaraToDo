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

	  //						//
	 //   ADMINS   //
	//			      //

Route::group(['middleware' => 'LaraToDo\Http\Middleware\AdminMiddleware'], function(){

	Route::match(['get', 'post'], '/admin', 'AdminController@show');

	Route::match(['get', 'post'], '/', function(){
		Auth::logout();
		return view('welcome');
	});

	//Route for searching users
	Route::any('/search', 'AdminController@showSearch');

	//Routes for managing users
	Route::match(['get', 'post'], '/admin/{user}/edituser', 'AdminController@edituserdetails');
	Route::match(['get', 'post'], '/admin/edit', 'AdminController@edituser');
	Route::match(['get', 'delete'], '/admin/{user}', 'AdminController@destroy');
	Route::get('adminedituser', function () {
    	return view('/adminedituser');
	});

	//Routes for editing current user profile
	Route::match(['get', 'post'], '/user/edit', 'EditProfileController@edituser');
	Route::match(['get', 'post'], '/edit', function(){
		return view('edituser');
	});

	//Routes for resetting password
	Route::match(['get', 'post'], '/resetpass', 'Auth\ResetPasswordController@reset');
	Route::match(['get', 'post'], 'resetpassword', function(){
		return view('auth/passwords/reset');
	});

	//Route for logging out
	Route::match(['get', 'post'], '/logout', function(){
		Auth::logout();
		return view('/login');
	});
});

	  //			 			 //
	 //   MEMBERS   //
	//			   		 //

Route::group(['middleware' => 'LaraToDo\Http\Middleware\MemberMiddleware'], function(){
	Route::match(['get', 'post'], '/index', 'Auth\LoginController@index');

	//Routes for managing tasks
	Route::post('/tasks/{task}/done', 'TaskController@done');
	Route::post('/tasks/{task}/undone', 'TaskController@undone');
	Route::delete('/tasks/{task}', 'TaskController@destroy');
	Route::get('/tasks/', 'TaskController@show');
	Route::post('/tasks', 'TaskController@store');
	Route::put('/tasks/', 'TaskController@update');

	//Routes for editing current user profile
	Route::match(['get', 'post'], '/user/edit', 'EditProfileController@edituser');
	Route::match(['get', 'post'], '/edit', function(){
		return view('edituser');
	});

	//Routes for resetting password
	Route::match(['get', 'post'], '/resetpass', 'Auth\ResetPasswordController@reset');
	Route::match(['get', 'post'], 'resetpassword', function(){
		return view('auth/passwords/reset');
	});

	//Route for logging out
	Route::match(['get', 'post'], '/logout', 'Auth\LoginController@logout')->name('auth.logout');

});

	  //			      //
	 //   GUESTS   //
	//			      //

	Route::get('/', function(){
		Auth::logout();
		return view('welcome');
	});

	Route::post('/checklogin', 'Auth\LoginController@checklogin')->name('checklogin');

	Route::match(['get', 'post'], '/logout', 'Auth\LoginController@logout')->name('auth.logout');

	Route::get('/about', function () {
	    return view('about');
	});

	//Routes for editing current user profile
	Route::match(['get', 'post'], '/user/edit', 'EditProfileController@edituser');
	Route::match(['get', 'post'], '/{user}/edit', 'EditProfileController@checkRole');
	Route::match(['get', 'post'], '/edit', function(){
		return view('edituser');
	});

	//Routes for registering
	Route::post('/register/create', 'Auth\RegisterController@create');
	Route::post('/register/', 'Auth\RegisterController@validator');
	Route::get('register', function(){
		return view('auth/register');
	});

	//Routes for verifying registration
	Auth::routes(['verify' => true]);
	Route::get('verify', function(){
		return view('auth/verify');
	});

	Route::post('/resetpass', 'Auth\ResetPasswordController@reset');

	  //				       //
   //		SUMMERNOTE  //
  //			         //

	Route::get('summernote',  'SummernoteController@show');
	Route::get('/get/{summernote}/summernote', 'SummernoteController@get');
	Route::post('store/summernote', 'SummernoteController@store')->name('summernotePersist');
	Route::delete('/summernote/{summernote}', 'SummernoteController@destroy');
	Route::get('/edit/{summernote}/summernote', 'SummernoteController@edit');
	Route::post('save/summernote', 'SummernoteController@update');

	Route::get('editor', 'SummernoteController@index')->name("show-editor");
	Route::get('editorbs3', 'SummernoteController@indexbs3'); // BootStrap 3 version of countimer's modal
