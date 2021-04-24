<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('user/login', [AuthController::class,'Login']);
    Route::post('user/logout', [AuthController::class, 'Logout']);
    Route::post('user/register', [AuthController::class,'Register']);
    Route::post('user/me', [AuthController::class,'me']);
    Route::get('user/userall', [AuthController::class,'findallUser']);
    Route::post('user/update', [AuthController::class,'Updated']);

    Route::get('tamu/userall', [AuthController::class,'findallTamu']);

    Route::post('access/add', [AccessController::class,'AddAccess']);
    Route::post('access/delete', [AccessController::class,'deleteAccess']);
    
    Route::post('user/detail/add', [StatusController::class,'AddStatus']);
    Route::post('user/detail/update', [StatusController::class,'UpdateStatus']);

    Route::post('departemen/all', [DepartemenController::class,'AllDepart']);
    Route::post('departemen/add', [DepartemenController::class,'AddDepart']);

    Route::post('proker/add', [ProkerController::class,'AddProker']);
    Route::get('proker/all', [ProkerController::class,'showProker']);
    Route::post('proker/update', [ProkerController::class,'updateProker']);
    Route::post('proker/delete', [ProkerController::class,'DeleteProker']);
    Route::post('proker/koment/add', [ProkerController::class,'ProkerKoment']);
    Route::get('proker/koment/all', [ProkerController::class,'KomentarAll']);
});