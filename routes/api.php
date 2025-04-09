<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Middleware\EnsureTokenIsValid;

Route::resource('/users',UserController::class)
    ->only('index', 'show', 'store');
    // ->middleware(EnsureTokenIsValid::class);

Route::get('/positions', [PositionController::class, 'index']);

Route::get('/token', TokenController::class);

// Route::apiResources([
//     'users' => UserController::class,
//     'positions' => PositionController::class,
//     'token' => TokenController::class,
// ]);