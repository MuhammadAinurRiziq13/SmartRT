<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\HouseController;
use App\Http\Controllers\Api\MonthlyFeeController;
use App\Http\Controllers\Api\ResidentController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('auth')->name('auth.')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Authenticated user info and logout
    Route::prefix('auth')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/me', 'me')->name('me');
    });

    Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
        Route::get('/summary', 'summary');
        Route::get('/detail', 'detail');
    });
    Route::prefix('residents')->controller(ResidentController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    Route::prefix('houses')->controller(HouseController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');

        Route::get('/{id}/occupancy-history', 'occupancyHistory');
        Route::get('/{id}/payment-history', 'paymentHistory');
    });

    Route::prefix('payments')->controller(MonthlyFeeController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::delete('/{id}', 'destroy');
    });

    Route::prefix('expenses')->controller(ExpenseController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::delete('/{id}', 'destroy');
    });
});