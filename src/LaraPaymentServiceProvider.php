<?php
namespace Laratalks\LaraPayment;

use Illuminate\Support\ServiceProvider;
use Laratalks\PaymentGateways\GatewayManager;

class LaraPaymentServiceProvider extends ServiceProvider 
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/payment-gateway.php' => config_path('payment-gateways.php')
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gateway-manager', function ($app) {
             return new GatewayManager($app['config']['payment-gateways']);
        });
    }

    public function provides()
    {
        return ['gateway-manager'];
    }
}