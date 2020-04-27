<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('tareas', 'TareasApiController');

// API Searches
Route::get('/tareasfiltradas', 'TareasApiController@search');

/*// Admin Invalidation at API Sign-in
Route::get('/soloTrabajadores',
    function() {
        return ["mensaje" => "Este servicio es solo para trabajadores locooo"];
    }
)->name('api.soloTrabajadores');