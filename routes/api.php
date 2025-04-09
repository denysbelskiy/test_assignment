<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TokenController;

Route::resource('/users',UserController::class)
    ->only('index', 'show', 'store');

Route::get('/positions', [PositionController::class, 'index']);
Route::get('/token', TokenController::class);