<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | This option controls which payment gateway is used by default.
    | Supported: "stripe", "paymob"
    |
    */
    'default' => env('PAYMENT_GATEWAY', 'stripe'),
];
