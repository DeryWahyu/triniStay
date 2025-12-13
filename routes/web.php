<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Owner\OwnerKostController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Guest Routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    // Role Selection
    Route::get('/role-selection', [AuthController::class, 'showRoleSelection'])->name('role.selection');

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Owner Registration
    Route::get('/register/owner', [AuthController::class, 'showRegisterOwner'])->name('register.owner');
    Route::post('/register/owner', [AuthController::class, 'registerOwner']);

    // Renter Registration
    Route::get('/register/renter', [AuthController::class, 'showRegisterRenter'])->name('register.renter');
    Route::post('/register/renter', [AuthController::class, 'registerRenter']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // SuperAdmin Dashboard (only superadmin)
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/dashboard/admin', function () {
            return view('dashboard.admin');
        })->name('dashboard.admin');
    });

    // Owner Routes (only owner)
    Route::middleware('role:owner')->prefix('dashboard/owner')->name('owner.')->group(function () {
        // Dashboard
        Route::get('/', [OwnerKostController::class, 'dashboard'])->name('dashboard');

        // Kost Management
        Route::get('/kost', [OwnerKostController::class, 'index'])->name('kost.index');
        Route::get('/kost/create', [OwnerKostController::class, 'create'])->name('kost.create');
        Route::post('/kost', [OwnerKostController::class, 'store'])->name('kost.store');
        Route::get('/kost/{boardingHouse}/edit', [OwnerKostController::class, 'edit'])->name('kost.edit');
        Route::put('/kost/{boardingHouse}', [OwnerKostController::class, 'update'])->name('kost.update');
        Route::delete('/kost/{boardingHouse}', [OwnerKostController::class, 'destroy'])->name('kost.destroy');
    });

    // Renter Dashboard (only renter)
    Route::middleware('role:renter')->group(function () {
        Route::get('/dashboard/renter', function () {
            return view('dashboard.renter');
        })->name('dashboard.renter');
    });
});
