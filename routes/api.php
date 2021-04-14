<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('user/login', [AuthController::class,'Login']);
    Route::post('user/logout', [AuthController::class, 'Logout']);
    Route::post('user/register', [AuthController::class,'Register']);
    Route::post('user/me', [AuthController::class,'me']);
    Route::get('user/userall', [AuthController::class,'findall']);
    Route::post('user/update', [AuthController::class,'Updated']);

    Route::post('access/add', [AccessController::class,'AddAccess']);

    
    Route::post('user/detail/add', [StatusController::class,'AddStatus']);
    Route::post('user/detail/update', [StatusController::class,'UpdateStatus']);

    Route::post('departemen/all', [DepartemenController::class,'AllDepart']);
    Route::post('departemen/add', [DepartemenController::class,'AddDepart']);
});