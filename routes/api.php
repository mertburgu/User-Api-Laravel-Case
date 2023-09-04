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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('user')->middleware(['authorization'])->group(function () {
    Route::post('/insert', 'UserController@insert');
    Route::get('/list', 'UserController@list');
    Route::put('/update/{user}', 'UserController@update');
    Route::delete('/delete/{user}', 'UserController@delete');
    Route::delete('/destroy/{user}', 'UserController@destroy');
});
