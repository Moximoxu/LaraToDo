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

Route::get('/login', 'HomeController@index');

Route::get('/fetch', 'TaskController@fetchtasks');
Route::post('/createTask', 'TaskController@createTask');
Route::get('/task/create', 'TaskController@create');

//Route::get('/login', 'LoginController@');

Route::post('/deletetask', 'TaskController@deleteTask');

Route::post('/updatetask', 'TaskController@updateTask');

Route::post('/donetask', 'TaskController@doneTask');
Route::post('/undonetask', 'TaskController@undoneTask');
Auth::routes();
