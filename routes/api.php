<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\UserController;


Route::get('/users',[UserController::class, 'index']);

Route::get('/users/{id}',[UserController::class, 'show']);

Route::get('/positions', [PositionController::class, 'index']);