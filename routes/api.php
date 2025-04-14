<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PositionController;
use Illuminate\Support\Facades\Route;

Route::resource('/users',UserController::class)
    ->only('index', 'show', 'store');

Route::get('/positions', [PositionController::class, 'index']);
Route::get('/token', TokenController::class);
