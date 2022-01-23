<?php

use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserController;
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


Route::name('api.')->group(function () {

    Route::post('register', [AuthController::class, 'register']);

    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('user', [UserController::class, 'getUser']);

        Route::post('logout', [AuthController::class, 'logout']);

        Route::apiResource('rooms', RoomController::class);

        Route::apiResource('events', EventController::class);

    });

});

