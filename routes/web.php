<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DeliveryOrderController;

// ==========================
// TEST MAIL (boleh tanpa login)
// ==========================
Route::get('/test-mail', function () {
    Mail::raw('Test email Laravel berhasil!', function ($message) {
        $message->to('nylasjdh@gmail.com')
                ->subject('Test Email');
    });

    return 'Email dikirim';
});


// ==========================
// HARUS LOGIN DULU
// ==========================
Route::middleware('auth')->group(function () {

    // BOOKING
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);

    // PAYMENT
    Route::post('/payment', [PaymentController::class, 'store']);
    Route::post('/payment/{id}/upload', [PaymentController::class, 'uploadProof']);
    Route::post('/payment/{id}/verify', [PaymentController::class, 'verify']);

    // DELIVERY ORDER
    Route::post('/do/{schedule_id}', [DeliveryOrderController::class, 'store']);
    Route::get('/driver/my-orders', [DeliveryOrderController::class, 'myOrders']);
    Route::post('/do/{id}/start', [DeliveryOrderController::class, 'startTrip']);
    Route::post('/do/{id}/finish', [DeliveryOrderController::class, 'finishTrip']);

});