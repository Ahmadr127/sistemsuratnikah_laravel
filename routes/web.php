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

    // Login MFA (PIN verification)
    Route::get('/login/verify-pin', [AuthController::class, 'showLoginVerifyPin'])->name('login.verify-pin.form');
    Route::post('/login/verify-pin', [AuthController::class, 'verifyLoginPin'])->name('login.verify-pin');

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
    Route::get('/marriage/print/{id}', [MarriageController::class, 'printPdf'])->name('marriage.print');
});

// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/marriages', [AdminController::class, 'marriages'])->name('admin.marriages');
    
    // Marriage Management
    Route::get('/admin/marriage/create', [AdminController::class, 'createMarriage'])->name('admin.marriage.create');
    Route::post('/admin/marriage/search-nik', [AdminController::class, 'searchNik'])->name('admin.marriage.search-nik');
    Route::get('/admin/marriage/create-form', [AdminController::class, 'createMarriageForm'])->name('admin.marriage.create-form');
    Route::post('/admin/marriage/store', [AdminController::class, 'storeMarriage'])->name('admin.marriage.store');
    Route::get('/admin/marriage/{id}', [AdminController::class, 'showMarriage'])->name('admin.marriage.show');
    Route::get('/admin/marriage/{id}/edit', [AdminController::class, 'editMarriage'])->name('admin.marriage.edit');
    Route::put('/admin/marriage/{id}', [AdminController::class, 'updateMarriage'])->name('admin.marriage.update');
    Route::delete('/admin/marriage/{id}', [AdminController::class, 'deleteMarriage'])->name('admin.marriage.delete');
    Route::get('/admin/marriage/{id}/print', [AdminController::class, 'printMarriage'])->name('admin.marriage.print');
    
    // KTP Data Management
    Route::get('/admin/ktp-data', [AdminController::class, 'ktpData'])->name('admin.ktp-data');
    Route::post('/admin/ktp/search', [AdminController::class, 'searchKtp'])->name('admin.ktp-search');
    Route::post('/admin/ktp/reset-mock', [AdminController::class, 'resetMockData'])->name('admin.ktp-reset-mock');
    Route::put('/admin/ktp/{nik}/update-marital-status', [AdminController::class, 'updateKtpMaritalStatus'])->name('admin.ktp-update-marital-status');
    
    // Home Settings
    Route::get('/admin/home-settings/edit', [AdminHomeSettingController::class, 'edit'])->name('admin.home-settings.edit');
    Route::post('/admin/home-settings/update', [AdminHomeSettingController::class, 'update'])->name('admin.home-settings.update');
    
    // KUA Management
    Route::resource('/admin/kuas', App\Http\Controllers\Admin\KuaController::class)->names([
        'index' => 'admin.kuas.index',
        'create' => 'admin.kuas.create',
        'store' => 'admin.kuas.store',
        'show' => 'admin.kuas.show',
        'edit' => 'admin.kuas.edit',
        'update' => 'admin.kuas.update',
        'destroy' => 'admin.kuas.destroy',
    ]);
});