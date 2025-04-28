<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\DonationCategoryController;
use App\Http\Controllers\API\DonationController;
use App\Http\Controllers\API\ExpenditureController;
use App\Http\Controllers\API\IndexDataController;
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

// Index Data Route
Route::get('/index-data', [IndexDataController::class, 'index']);

// Donation Categories Route
Route::get('/donation-categories', [DonationCategoryController::class, 'index']);

// Campaigns Routes
Route::get('/campaigns', [CampaignController::class, 'index']);
Route::get('/campaigns/{id}', [CampaignController::class, 'show']);
Route::get('/campaigns/{id}/donations', [CampaignController::class, 'donations']);
Route::get('/campaigns/{id}/expenditures', [CampaignController::class, 'expenditures']);

// Donations Routes
Route::get('/donations', [DonationController::class, 'index']);
Route::middleware('auth:sanctum')->get('/donations/my-donations', [DonationController::class, 'userDonations']);

// Expenditures Route
Route::get('/expenditures', [ExpenditureController::class, 'index']);

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
