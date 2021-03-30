<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class,'Login']);
    Route::post('logout', [AuthController::class, 'Logout']);
    Route::post('register', [AuthController::class,'Register']);
    Route::post('me', [AuthController::class,'me']);
    Route::get('userall', [AuthController::class,'findall']);
    Route::post('update', [AuthController::class,'Updated']);
});