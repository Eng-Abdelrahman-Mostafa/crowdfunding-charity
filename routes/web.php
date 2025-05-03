<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
});

// Payment redirect routes
Route::prefix('payments')->group(function () {
    Route::get('/success', [PaymentController::class, 'success'])->name('payments.success');
    Route::get('/fail', [PaymentController::class, 'fail'])->name('payments.fail');
    Route::get('/pending', [PaymentController::class, 'pending'])->name('payments.pending');
});

// Donation success route
Route::get('/donations/{id}/success', function ($id) {
    return view('donations.success', ['donation_id' => $id]);
})->name('donations.success');
