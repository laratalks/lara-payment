<?php

return [

    'default_provider' => 'zarinpal',

    'providers' => [
        'zarinpal' => [
            'api_key' => '', // Zarinpal Merchant Code
        ],
        
        'upal' => [
            'api_key' => '',
            'gateway_id' => ''
        ]

    ],

    'proxy' => [
        'enabled' => false, // true, when you want send requests through proxy
        'type' => 'http', // available: http, https, socks5(only on non-wsdl requests)
        'use_credentials' => false, // true, if your proxy needs credentials
        'host' => 'localhost',
        'port' => 8123,
        'username' => '',
        'password' => ''
    ]
];