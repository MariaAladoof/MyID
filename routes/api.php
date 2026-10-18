<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriberController;
use App\Http\Requests\StoreSubscriberRequest;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);

Route::get('/auth/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/subscribers', [SubscriberController::class, 'index']);
    Route::post('/subscribers', [SubscriberController::class, 'store']);
});
