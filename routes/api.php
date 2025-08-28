<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceApiController;
use App\Http\Controllers\Auth\AuthApiController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::post('logout', [AuthApiController::class, 'logout']);

    // Route::get('services', [ServiceController::class, 'getServiceList']);
    Route::post('book-now', [BookingController::class, 'storeBooking']);
    Route::get('bookings', [BookingController::class, 'getBookingList']);

    Route::resource('services', ServiceApiController::class)->names('api.services');
});
