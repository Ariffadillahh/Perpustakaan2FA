<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController; // <--- WAJIB ADA
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Route
Route::get('/', [AuthController::class, 'index'])->name('landing');

// Guest Routes (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.submit');
    Route::get('/register/verify', [AuthController::class, 'showOtpForm'])->name('auth.otp.form');
    Route::post('/register/verify', [AuthController::class, 'verifyOtp'])->name('auth.otp.submit');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.submit');

    Route::get('/login/challenge', [AuthController::class, 'showLogin2faForm'])->name('auth.login.2fa');
    Route::post('/login/challenge', [AuthController::class, 'verifyLogin2fa'])->name('auth.login.2fa.verify');

    Route::get('/forgot-password/verify', [AuthController::class, 'showForgotOtpForm'])->name('auth.forgot.otp');
    Route::post('/forgot-password', [AuthController::class, 'initiateForgotPassword'])->name('auth.forgot.submit');
    Route::post('/forgot-password/verify', [AuthController::class, 'verifyForgotOtp'])->name('auth.forgot.verify');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // 1. Dashboard & Profile Umum
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // 2FA Management
    Route::get('/setup-2fa', [AuthController::class, 'show2faSetup'])->name('auth.2fa.setup');
    Route::post('/setup-2fa', [AuthController::class, 'enable2fa'])->name('auth.2fa.enable');
    Route::post('/disable-2fa', [AuthController::class, 'disable2fa'])->name('auth.2fa.disable');

    // --- AREA KHUSUS ADMIN & PETUGAS (Role 1 & 2) ---
    Route::middleware('is_staff')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Buku
        Route::resource('books', BooksController::class)->except(['show', 'index']);

        // Profil & 2FA Dashboard Admin
        Route::get('/dashboard/profile', [ProfileController::class, 'dashboardProfile'])->name('profile.dasboard');
        Route::get('/dashboard/profile/2fa-setup', [AuthController::class, 'show2faSetupDashboard'])->name('profile-setup.dasboard');

        // Manajemen Peminjaman (Admin)
        Route::get('/admin/loans', [LoansController::class, 'index'])->name('admin.loans.index');
        Route::patch('/loans/{id}/return', [LoansController::class, 'updateStatus'])->name('loans.updateStatus');
        Route::get('/loans/export', [LoansController::class, 'export'])->name('loans.export');
        Route::post('/loans/import', [LoansController::class, 'import'])->name('loans.import');


        Route::resource('categories', CategoriesController::class)
            ->only(['store', 'update', 'destroy']);

        Route::middleware('is_admin')->group(function () {
            // --- USER MANAGEMENT ---
            Route::get('/users', [AuthController::class, 'users'])->name('admin.index');
            Route::post('/users', [AuthController::class, 'store'])->name('admin.create');
            Route::put('/users/{id}', [AuthController::class, 'update'])->name('admin.update');

            // --- BACKUP MANAGEMENT ---
            Route::post('/backups', [BackupController::class, 'store'])->name('backups.store');
            Route::post('/backups/{id}/restore', [BackupController::class, 'restore'])->name('backups.restore');
            Route::delete('/backups/{id}', [BackupController::class, 'destroy'])->name('backups.destroy');
        });
    });

    // 1. Katalog Buku (Index)
    Route::get('/books', [BooksController::class, 'index'])->name('books.index');

    // 2. Detail Buku (Show)
    Route::get('/books/{id}', [BooksController::class, 'show'])->name('books.show');

    // 3. Peminjaman (Member)
    Route::resource('loans', LoansController::class)->only(['index', 'store']);
});
