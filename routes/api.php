<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

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

/* Rota para fazer login na API */
Route::post('login', 'App\Http\Controllers\API\LoginController@login');

/* Rotas de usuário só são acessadas com autorização */
Route::middleware('auth:api')->group( function () {
    Route::apiResource('users', 'App\Http\Controllers\API\UserController');
});
