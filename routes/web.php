<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminHomeSettingController;
use App\Http\Controllers\MarriageController;
use App\Http\Controllers\VerificationController;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.auth'); })->name('login');
    Route::get('/register', function () { return view('auth.auth'); })->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    // Forgot Password (PIN based)
    Route::get('/forgot-password', [VerificationController::class, 'showForgotForm'])->name('forgot.password');
    Route::post('/forgot-password', [VerificationController::class, 'sendResetPin']);

    // PIN Verification (shared for register and password reset)
    Route::get('/verify-pin', [VerificationController::class, 'showVerifyForm'])->name('pin.verify.form');
    Route::post('/verify-pin', [VerificationController::class, 'verifyPin'])->name('pin.verify');

    // Password Reset after PIN verified
    Route::get('/reset-password', [VerificationController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [VerificationController::class, 'resetPassword'])->name('password.reset');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Marriage Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/marriage/request', [MarriageController::class, 'showRequestForm'])->name('marriage.request');
    Route::post('/marriage/search-nik', [MarriageController::class, 'searchNik'])->name('marriage.search-nik');
    Route::post('/marriage/request', [MarriageController::class, 'submitRequest'])->name('marriage.submit');
    Route::get('/marriage/status', [MarriageController::class, 'status'])->name('marriage.status');
});