<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminHomeSettingController;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
