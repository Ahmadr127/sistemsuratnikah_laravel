<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminHomeSettingController;
use App\Http\Controllers\MarriageController;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.auth'); })->name('login');
    Route::get('/register', function () { return view('auth.auth'); })->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Marriage Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/marriage/request', [MarriageController::class, 'showRequestForm'])->name('marriage.request');
    Route::post('/marriage/request', [MarriageController::class, 'submitRequest'])->name('marriage.submit');
    Route::get('/marriage/status', [MarriageController::class, 'status'])->name('marriage.status');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/marriages', [AdminController::class, 'marriages'])->name('marriages');

    // Marriage Management
    Route::get('/marriage/create', [AdminController::class, 'createMarriage'])->name('marriage.create');
    Route::post('/marriage/search-nik', [AdminController::class, 'searchNik'])->name('marriage.search-nik');
    Route::get('/marriage/create-form', [AdminController::class, 'createMarriageForm'])->name('marriage.create-form');
    Route::post('/marriage/store', [AdminController::class, 'storeMarriage'])->name('marriage.store');

    // KTP Data Management
    Route::get('/ktp-data', [AdminController::class, 'ktpData'])->name('ktp-data');
    Route::post('/ktp-search', [AdminController::class, 'searchKtp'])->name('ktp-search');

    // Home Settings
    Route::get('/home-settings', [AdminHomeSettingController::class, 'edit'])->name('home-settings.edit');
    Route::put('/home-settings', [AdminHomeSettingController::class, 'update'])->name('home-settings.update');
});