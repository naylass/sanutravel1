<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Payment;
use App\Observers\PaymentObserver;
use App\Http\Responses\LogoutResponse as CustomLogoutResponse;
use Filament\Auth\Http\Responses\LogoutResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponse::class, CustomLogoutResponse::class);
    }

    public function boot(): void
    {
        Payment::observe(PaymentObserver::class);
    }
}
