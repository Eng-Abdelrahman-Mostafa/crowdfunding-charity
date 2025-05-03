<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment gateway that will be used when
    | processing donations. Supported: "fawaterak"
    |
    */
    'default_gateway' => env('PAYMENT_GATEWAY', 'fawaterak'),

    /*
    |--------------------------------------------------------------------------
    | Fawaterak Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Fawaterak payment gateway
    |
    */
    'fawaterak' => [
        'mode' => env('FAWATERAK_MODE', 'sandbox'), // sandbox or live
        'api_key' => env('FAWATERAK_API_KEY'),
        'vendor_key' => env('FAWATERAK_VENDOR_KEY'), // Used for webhook hash verification
        'provider_key' => env('FAWATERAK_PROVIDER_KEY'), // Used for iframe integration
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Logging
    |--------------------------------------------------------------------------
    |
    | This option determines the logging configuration for payment gateways
    |
    */
    'logging' => [
        'channel' => env('PAYMENT_LOG_CHANNEL', 'payment'),
    ],
];
