<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Log;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/events/allEvents', [EventController::class, 'allEvents']);
    Route::resource("events", EventController::class);
    Route::resource("pets", PetController::class);
});