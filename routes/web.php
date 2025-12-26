<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Owner\OwnerKostController;
use App\Http\Controllers\Renter\BookingController;
use App\Http\Controllers\Renter\OrderController;
use App\Http\Controllers\Renter\RenterDashboardController;
use App\Http\Controllers\Renter\ReviewController;
use App\Http\Controllers\Renter\RoomMatchController;
use App\Http\Controllers\Renter\SearchController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Models\BoardingHouse;
use App\Models\Review;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    $boardingHouses = BoardingHouse::where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();

    // Get published reviews for landing page
    $reviews = Review::where('is_published', true)
        ->with(['user', 'boardingHouse'])
        ->orderBy('created_at', 'desc')
        ->take(6)
        ->get();

    return view('landing', compact('boardingHouses', 'reviews'));
})->name('home');

// Kost Detail - requires login
Route::get('/kost/{slug}', [RenterDashboardController::class, 'showKos'])->middleware('auth')->name('kost.detail');

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
    Route::middleware('role:superadmin')->prefix('dashboard/superadmin')->name('superadmin.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [SuperAdminController::class, 'users'])->name('users.index');
        Route::delete('/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('users.destroy');
        Route::post('/users/{user}/toggle-block', [SuperAdminController::class, 'toggleBlockUser'])->name('users.toggle-block');
        Route::get('/kost', [SuperAdminController::class, 'boardingHouses'])->name('kost.index');
        Route::get('/activity', [SuperAdminController::class, 'activityLogs'])->name('activity.index');
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

        // Room Management
        Route::get('/kost/{boardingHouse}/rooms', [\App\Http\Controllers\Owner\RoomManagementController::class, 'index'])->name('rooms.index');
        Route::post('/kost/{boardingHouse}/rooms', [\App\Http\Controllers\Owner\RoomManagementController::class, 'store'])->name('rooms.store');
        Route::post('/kost/{boardingHouse}/rooms/bulk', [\App\Http\Controllers\Owner\RoomManagementController::class, 'bulkStore'])->name('rooms.bulk-store');
        Route::patch('/kost/{boardingHouse}/rooms/{room}/status', [\App\Http\Controllers\Owner\RoomManagementController::class, 'updateStatus'])->name('rooms.update-status');
        Route::delete('/kost/{boardingHouse}/rooms/{room}', [\App\Http\Controllers\Owner\RoomManagementController::class, 'destroy'])->name('rooms.destroy');

        // Booking Management
        Route::get('/bookings', [\App\Http\Controllers\Owner\BookingManagementController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [\App\Http\Controllers\Owner\BookingManagementController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking}/approve', [\App\Http\Controllers\Owner\BookingManagementController::class, 'approve'])->name('bookings.approve');
        Route::post('/bookings/{booking}/reject', [\App\Http\Controllers\Owner\BookingManagementController::class, 'reject'])->name('bookings.reject');
        Route::post('/bookings/{booking}/complete', [\App\Http\Controllers\Owner\BookingManagementController::class, 'complete'])->name('bookings.complete');

        // Profile & Settings
        Route::get('/profile', [\App\Http\Controllers\Owner\ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [\App\Http\Controllers\Owner\ProfileController::class, 'update'])->name('profile.update');
    });

    // Renter Routes (only renter)
    Route::middleware('role:renter')->prefix('dashboard')->name('renter.')->group(function () {
        // Dashboard / Beranda
        Route::get('/renter', [RenterDashboardController::class, 'index'])->name('dashboard');

        // Kos Detail
        Route::get('/kost/{slug}', [RenterDashboardController::class, 'showKos'])->name('kost.show');

        // Cari Kos (Search)
        Route::get('/cari-kos', [SearchController::class, 'index'])->name('kos.search');

        // Booking
        Route::get('/booking/{slug}', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
        Route::post('/booking/{booking}/payment-proof', [BookingController::class, 'uploadPaymentProof'])->name('booking.payment-proof');
        Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
        Route::post('/booking/{booking}/accept-shared', [BookingController::class, 'acceptSharedBooking'])->name('booking.accept-shared');
        Route::post('/booking/{booking}/reject-shared', [BookingController::class, 'rejectSharedBooking'])->name('booking.reject-shared');

        // Orders / Pemesanan
        Route::get('/pemesanan', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/pemesanan/{booking}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/pemesanan/{booking}/download-receipt', [OrderController::class, 'downloadReceipt'])->name('orders.download-receipt');

        // Profile
        Route::get('/profil', [\App\Http\Controllers\Renter\ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profil', [\App\Http\Controllers\Renter\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profil/password', [\App\Http\Controllers\Renter\ProfileController::class, 'updatePassword'])->name('profile.password');

        // Reviews
        Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

        // Room Match / Cari Teman
        Route::get('/room-match', [RoomMatchController::class, 'index'])->name('room-match.index');
        Route::get('/room-match/create', [RoomMatchController::class, 'create'])->name('room-match.create');
        Route::post('/room-match', [RoomMatchController::class, 'store'])->name('room-match.store');
        Route::get('/room-match/edit', [RoomMatchController::class, 'edit'])->name('room-match.edit');
        Route::put('/room-match', [RoomMatchController::class, 'update'])->name('room-match.update');
        Route::get('/room-match/{id}', [RoomMatchController::class, 'show'])->name('room-match.show');
    });
});
