<?php

namespace App\Providers;

use App\PaymentGateways\Contracts\PaymentGatewayInterface;
use App\PaymentGateways\FawaterakPaymentGateway;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, function ($app) {
            return new FawaterakPaymentGateway();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
