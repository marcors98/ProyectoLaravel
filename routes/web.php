<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// Admin login/dashboard routes
Route::get('/', 'AdminController@dashboard') -> name('admin.dashboard');
Route::get('/admin', 'AdminController@dashboard') -> name('admin.dashboard');
Route::get('/home', 'AdminController@dashboard')->name('admin.dashboard');
Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

// Atajo para establecer las 7 rutas básicas de un recurso (index, show, create, store, edit, update, destroy)
Route::resource('tareas', 'Admin\TareasController');
Route::resource('usuarios', 'Admin\UsuarioController');

// Search route
Route::get('/searchTareas', 'Admin\TareasController@search');
Route::get('/searchUsuarios', 'Admin\UsuarioController@search');
