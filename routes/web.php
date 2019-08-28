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

Route::get('/fetch', 'TaskController@fetchtasks')->name('task.fetch');
Route::post('/createtask', 'TaskController@createTask')->name('task.create');
Route::get('/task/create', 'TaskController@create');

Route::post('/deletetask', 'TaskController@deleteTask')->name('task.delete');

Route::post('/updatetask', 'TaskController@updateTask')->name('task.update');

Route::post('/donetask', 'TaskController@doneTask')->name('task.done');
Route::post('/undonetask', 'TaskController@undoneTask')->name('task.undone');

Auth::routes(['register' => false]);

Route::get('/', ['middleware' =>'guest', function(){
  return view('auth.login');
}]);

Route::get('/', function(){
	Auth::logout();
	return view('welcome');
});