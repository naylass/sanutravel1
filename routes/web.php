<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Service;


Route::get('/', function () {
    $services = Service::all();
    return view('landing', compact('services'));
})->name('home');

Route::get('/booking/create', [BookingController::class, 'create'])
    ->name('booking.create');
Route::post('/booking/create', [BookingController::class, 'store']);

Route::get('/booking/success/{code}', [BookingController::class, 'success'])
    ->name('booking.success');

Route::get('/tracking', [BookingController::class, 'tracking'])
    ->name('tracking');

Route::patch('/booking/{id}/cancel', [BookingController::class, 'cancel'])
    ->name('booking.cancel');

Route::get('/payment/check', [PaymentController::class, 'check'])
    ->name('payment.check');

Route::post('/payment/{id}/upload', [PaymentController::class, 'upload'])
    ->name('payment.upload');

Route::get('/payment-proof/{filename}', function ($filename) {

    $path = storage_path('app/public/payment-proofs/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    return Response::file($path);
});

Route::get(
    '/driver/cash-success/{id}',
    [PaymentController::class, 'cashSuccess']
)->name('driver.cash.success');

Route::post('/payment/{id}/verify', [PaymentController::class, 'verify'])
    ->name('payment.verify');
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/driver/dashboard', [DriverController::class, 'dashboard'])
        ->name('driver.dashboard');
    Route::get('/driver/profile', [DriverController::class, 'profile'])
        ->name('driver.profile');
    Route::get('/driver/delivery', [DriverController::class, 'delivery'])
        ->name('driver.delivery');
    Route::patch('/driver/delivery/{id}/update', [DriverController::class, 'updateStatus'])
        ->name('driver.delivery.update');
    Route::get('/driver/my-orders', [DeliveryOrderController::class, 'myOrders'])
        ->name('driver.orders');
    Route::get('/driver/payments', [PaymentController::class, 'driverCashPage'])
        ->name('driver.payment.page');
    Route::post('/driver/payments/{id}/receive', [PaymentController::class, 'receiveCash'])
        ->name('driver.payment.receive');
    Route::post('/do/{schedule_id}', [DeliveryOrderController::class, 'store']);
    Route::post('/do/{id}/start', [DeliveryOrderController::class, 'startTrip']);
    Route::post('/do/{id}/finish', [DeliveryOrderController::class, 'finishTrip']);
});

Route::middleware(['auth'])->group(function () {
    Route::patch('/admin/booking/{id}/approve-cancel', [BookingController::class, 'approveCancel'])
        ->name('admin.booking.approveCancel');
    Route::patch('/admin/booking/{id}/reject-cancel', [BookingController::class, 'rejectCancel'])
        ->name('admin.booking.rejectCancel');
});
