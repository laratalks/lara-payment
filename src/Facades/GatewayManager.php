<?php
namespace Laratalks\LaraPayment\Facades;

use Illuminate\Support\Facades\Facade;

class GatewayManager extends Facade
{
    protected static function getFacadeAccessor() { return 'gateway-manager'; }
}