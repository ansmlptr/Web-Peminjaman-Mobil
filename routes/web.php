<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KatalogController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BookingController2 as UserBookingController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\KatalogController as UserKatalogController;
use App\Http\Controllers\User\BookingController as UserBookingControllerNew;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('user.home');

// Customer Authentication Routes
Route::middleware('guest:customer')->group(function () {
    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('user.register');
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('user.login');
});

// User Routes
Route::prefix('user')->name('user.')->group(function () {
    // Public user routes
    Route::get('/katalog', [UserKatalogController::class, 'index'])->name('katalog');
    Route::get('/katalog/{id}', [UserKatalogController::class, 'detail'])->name('katalog.detail');

    // Authenticated customer routes
    Route::middleware('auth:customer')->group(function () {
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

        // Booking routes
        Route::post('/booking', [UserBookingControllerNew::class, 'store'])->name('booking.store');
        Route::get('/history', [UserBookingControllerNew::class, 'history'])->name('history');
        Route::get('/booking/{id}', [UserBookingControllerNew::class, 'show'])->name('booking.show');

        // Payment routes
        Route::get('/payment/{id_booking}', [PaymentController::class, 'index'])->name('payment.index');
        Route::post('/payment/{id_booking}', [PaymentController::class, 'store'])->name('payment.store');

        Route::get('/payment/{id_booking}/proof', [PaymentController::class, 'showProof'])->name('payment.proof');

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::get('/profile/export', [ProfileController::class, 'exportData'])->name('profile.export');
        Route::delete('/profile', [ProfileController::class, 'deleteAccount'])->name('profile.delete');
    });
});

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Authenticated admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Katalog/Kendaraan management
        Route::resource('katalog', KatalogController::class)->names([
            'index' => 'admin.katalog.index',
            'create' => 'admin.katalog.create',
            'store' => 'admin.katalog.store',
            'show' => 'admin.katalog.show',
            'edit' => 'admin.katalog.edit',
            'update' => 'admin.katalog.update',
            'destroy' => 'admin.katalog.destroy'
        ]);

        // Booking management
        Route::prefix('booking')->name('admin.booking.')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('index');
            Route::get('/{id}', [BookingController::class, 'show'])->name('show');
            Route::patch('/{id}/complete', [BookingController::class, 'complete'])->name('complete');
            Route::get('/filter/status', [BookingController::class, 'filterByStatus'])->name('filter');
        });

        // Pembayaran management
        Route::resource('pembayaran', PembayaranController::class)->names([
            'index' => 'admin.pembayaran.index',
            'show' => 'admin.pembayaran.show',
            'update' => 'admin.pembayaran.update'
        ])->only(['index', 'show', 'update']);

        // Additional payment actions
        Route::patch('/pembayaran/{pembayaran}/confirm', [PembayaranController::class, 'confirm'])->name('admin.pembayaran.confirm');
        Route::patch('/pembayaran/{pembayaran}/reject', [PembayaranController::class, 'reject'])->name('admin.pembayaran.reject');
    });
});