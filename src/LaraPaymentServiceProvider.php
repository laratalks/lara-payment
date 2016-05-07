<?php
namespace Laratalks\LaraPayment;

use Illuminate\Support\ServiceProvider;
use Laratalks\PaymentGateways\Configs\Config;
use Laratalks\PaymentGateways\Configs\ProviderConfig;
use Laratalks\PaymentGateways\Configs\ProxyConfig;
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
             return new GatewayManager($this->buildConfigs($app['config']['payment-gateways']));
        });
    }

    protected function buildConfigs(array $configs)
    {
        $config = new Config();

        if (array_get($configs, 'default_provider') !== null) {
            $config->setDefaultProvider(array_get($configs, 'default_provider'));
        }

        // set proxy configs
        if (($proxy = array_get($configs, 'proxy')) !== null) {
            $proxyConfig = new ProxyConfig();

            if (array_get($proxy, 'enabled') !== null) {
                $proxyConfig->setEnabled(array_get($proxy, 'enabled'));
            }

            if (array_get($proxy, 'type') !== null) {
                $proxyConfig->setType(array_get($proxy, 'type'));
            }

            if (array_get($proxy, 'host') !== null) {
                $proxyConfig->setHost(array_get($proxy, 'host'));
            }

            if (array_get($proxy, 'port') !== null) {
                $proxyConfig->setPort(array_get($proxy, 'port'));
            }

            if (array_get($proxy, 'use_credentials') !== null) {
                $proxyConfig->setUseCredentials(array_get($proxy, 'use_credentials'));
            }

            if (array_get($proxy, 'username') !== null) {
                $proxyConfig->setUsername(array_get($proxy, 'username'));
            }

            if (array_get($proxy, 'password') !== null) {
                $proxyConfig->setPassword(array_get($proxy, 'password'));
            }

            $config->setProxy($proxyConfig);
        }


        // set providers config
        if (($providers = array_get($configs, 'providers'))  !== null && is_array($providers)) {
            foreach ($providers as $name => $provider) {
                $providerConfig = new ProviderConfig($name);

                foreach ($provider as $key => $value) {
                    if ($key === 'api_key') {
                        $providerConfig->setApiKey($value);
                        continue;
                    }

                    $providerConfig->set($key, $value);
                }

                $config->addProvider($providerConfig);
            }
        }
        
        return $config;
    }

    public function provides()
    {
        return ['gateway-manager'];
    }
}