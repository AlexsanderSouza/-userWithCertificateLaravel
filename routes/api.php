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
Route::post('login', 'App\Http\Controllers\API\LoginController@login')->name('users_login');
Route::post('users', 'App\Http\Controllers\API\UserController@store')->name('users_store');

/* Rotas de usuário só são acessadas com autorização */
Route::middleware('auth:api')->group( function () {
    Route::apiResource('users', 'App\Http\Controllers\API\UserController')->except([
        'store'
    ]);
    Route::group(['prefix' => 'users/{iserId}'], function () {
        Route::get('certificate', 'App\Http\Controllers\API\CertificatesController@show')->name('user_certificate');
        Route::post('certificate', 'App\Http\Controllers\API\CertificatesController@store')->name('user_certificate_store');
    });
});
