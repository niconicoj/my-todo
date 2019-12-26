<?php

use Illuminate\Http\Request;

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

Route::prefix('user')->group( function() {
    Route::post('signup','UserController@signup');
    Route::post('login','UserController@login');
    Route::get('logout','UserController@logout');
    Route::get('', 'AuthController@getAuthUser');
});

Route::prefix('todo')->middleware(['middleware' => 'auth:api'])->group( function() {
    Route::post('','TodoController@create');
    Route::get('','TodoController@getAll');
    Route::get('/{id}','TodoController@get');
});


