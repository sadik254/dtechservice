<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;

// Register and login routes for Users without authentication middleware
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('forgot-password', [UserController::class, 'forgotPassword']);

// Update user profile route with authentication middleware
Route::middleware('auth:sanctum')->put('/user', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->get('user', [UserController::class, 'show']);

// register and login routes for admins without authentication
Route::post('admin/register', [AdminController::class, 'register']); // Register
Route::post('admin/login', [AdminController::class, 'login']); // Login

// Admin routes authenticated with sanctum middleware
Route::middleware('auth:sanctum')->get('admin/profile', [AdminController::class, 'show']); // Show profile
Route::middleware('auth:sanctum')->put('admin/profile', [AdminController::class, 'update']); // Update profile

// Service routes. All service routes will be without sanctum except create and update
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('services', [ServiceController::class, 'create']);
    Route::put('services/{id}', [ServiceController::class, 'update']);
    Route::delete('services/{id}', [ServiceController::class, 'delete']);
});
Route::get('services', [ServiceController::class, 'index']); // Get all services
Route::get('services/{id}', [ServiceController::class, 'show']); // Show service

// Appointment create and update with sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('appointments', [AppointmentController::class, 'store']);
    Route::get('appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('appointments/{id}', [AppointmentController::class, 'update']);
    Route::get('/user/appointments', [AppointmentController::class, 'userAppointments']);
});

// Appointment delete 
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy']);
});