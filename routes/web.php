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

Route::get('/index', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::post('/checklogin', 'Auth\LoginController@checklogin')->name('checklogin');
Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::get('/login', function(){
	return redirect('auth/login');
});

Route::post('/tasks/{task}/done', 'TaskController@done');
Route::post('/tasks/{task}/undone', 'TaskController@undone');
Route::delete('/tasks/{task}', 'TaskController@destroy');

Route::get('/tasks/', 'TaskController@show');
Route::post('/tasks', 'TaskController@store');

Route::put('/tasks/', 'TaskController@update');


Auth::routes(['register' => false]);

Route::get('/', ['middleware' =>'guest', function(){
  return view('auth.login');
}]);

Route::get('/', function(){
	Auth::logout();
	return view('welcome');
});