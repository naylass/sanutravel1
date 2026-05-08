<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Service;

Route::get('/', function () {
    $services = Service::all();
    return view('landing', compact('services'));
})->name('home');

Route::get('/auth.login', [LoginController::class, 'showLoginForm'])
    ->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])
    ->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])
        ->name('customer.dashboard');
    Route::get('/customer/booking', [BookingController::class, 'create'])
        ->name('customer.booking');
    Route::post('/customer/booking/store', [BookingController::class, 'store'])
        ->name('customer.booking.store');
    Route::get('/customer/history', [BookingController::class, 'index'])
        ->name('customer.history');
    Route::patch('/customer/booking/{id}/cancel', [BookingController::class, 'cancel'])
        ->name('customer.booking.cancel');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/driver/dashboard', [DriverController::class, 'dashboard'])
        ->name('driver.dashboard');
    Route::get('/driver/my-orders', [DeliveryOrderController::class, 'myOrders']);
    Route::post('/do/{schedule_id}', [DeliveryOrderController::class, 'store']);
    Route::post('/do/{id}/start', [DeliveryOrderController::class, 'startTrip']);
    Route::post('/do/{id}/finish', [DeliveryOrderController::class, 'finishTrip']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/payment', [PaymentController::class, 'store']);
    Route::post('/payment/{id}/upload', [PaymentController::class, 'uploadProof']);
    Route::post('/payment/{id}/verify', [PaymentController::class, 'verify']);
});

Route::patch('/customer/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('customer.booking.cancel');

Route::patch('/admin/booking/{id}/approve-cancel', [BookingController::class, 'approveCancel']);

Route::patch('/admin/booking/{id}/reject-cancel', [BookingController::class, 'rejectCancel']);

Route::middleware(['auth'])->group(function () {
    Route::get('/driver/delivery', [DeliveryOrderController::class, 'index'])
        ->name('driver.delivery');
    Route::patch(
        '/driver/delivery/{id}/update',
        [DeliveryOrderController::class, 'updateStatus']
    )->name('driver.delivery.update');
});
