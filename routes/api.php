<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthorizationMiddleware;

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


Route::prefix('user')->middleware([AuthorizationMiddleware::class])->group(function () {
    Route::get('/list', [UserController::class, 'list']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/insert', [UserController::class, 'insert']);
    Route::post('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);
    Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
});
