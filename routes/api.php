<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\RecurringExpenseController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\UniqueExpenseController;
use Illuminate\Support\Facades\Log;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::resource('uniqueExpenses', controller: UniqueExpenseController::class);
    Route::resource('recurringExpenses', controller: RecurringExpenseController::class);
    Route::resource('reminders', controller: ReminderController::class);

    // Route::get('/events/allEvents', [EventController::class, 'allEvents']);
});