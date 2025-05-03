<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    
    // Social Authentication Routes
    Route::get('/redirect/{provider}', [AuthController::class, 'redirectToProvider']);
    Route::post('/callback/{provider}', [AuthController::class, 'handleProviderCallback']);
    
    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
    });
});

// Payment Routes
Route::prefix('payments')->group(function () {
    // Payment methods (public)
    Route::get('/methods', [PaymentController::class, 'getPaymentMethods']);
    
    // Payment webhook (public)
    Route::post('/webhook/{gateway?}', [PaymentController::class, 'webhook']);
    
    // Payment verification (public)
    Route::get('/verify/{paymentId}', [PaymentController::class, 'verifyPayment']);
    
    // Protected payment routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/initiate', [PaymentController::class, 'initiatePayment']);
    });
});
