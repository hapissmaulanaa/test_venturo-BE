<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleBookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleUsageController;
use App\Http\Controllers\BookingApprovalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Proses LOGIN dan LOGOUT
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// Route untuk CRUD User (admin & )
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Route untuk CRUD kendaraan
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::put('/vehicles/{id}', [VehicleController::class, 'update']);
    Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy']);

    // Route untuk CRUD driver
    Route::get('/drivers', [DriverController::class, 'index']);
    Route::get('/drivers/{id}', [DriverController::class, 'show']);
    Route::post('/drivers', [DriverController::class, 'store']);
    Route::put('/drivers/{id}', [DriverController::class, 'update']);
    Route::delete('/drivers/{id}', [DriverController::class, 'destroy']);

    // Route untuk peminjaman kendaraan
    Route::post('/vehicle-bookings', [VehicleBookingController::class, 'store']);
    Route::get('/vehicle-bookings', [VehicleBookingController::class, 'index']);
    Route::get('/vehicle-bookings/{id}', [VehicleBookingController::class, 'show']);
    Route::put('/vehicle-bookings/{id}', [VehicleBookingController::class, 'update']);
    Route::delete('/vehicle-bookings/{id}', [VehicleBookingController::class, 'destroy']);

    // Route untuk approve booking kendaraan
    Route::get('/booking-approvals', [BookingApprovalController::class, 'index']);
Route::put('/booking-approvals/approve/{id}', [BookingApprovalController::class, 'approve']);
Route::put('/booking-approvals/reject/{id}', [BookingApprovalController::class, 'reject']);


    // Route untuk penggunaan kendaraan
    Route::post('/vehicle-usages', [VehicleUsageController::class, 'store']);
    Route::get('/vehicle-usages/{usageId}', [VehicleUsageController::class, 'show']);
    Route::get('/vehicle-usages', [VehicleUsageController::class, 'index']);
    Route::put('/vehicle-usages/{usageId}', [VehicleUsageController::class, 'update']);
    Route::delete('/vehicle-usages/{usageId}', [VehicleUsageController::class, 'destroy']);
});
