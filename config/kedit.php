<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kedit System Configuration
    |--------------------------------------------------------------------------
    |
    */
    // Testing
    // 'base_url' => env('KEDIT_BASE_URL', 'http://127.0.0.1:8000'),
    // 'pos_base_url' => env('POS_BASE_URL', 'http://127.0.0.1:8001'),

    // Sandbox
    'base_url' => env('KEDIT_BASE_URL', 'https://sandbox-sidik.smailtek.id'),
    'pos_base_url' => env('POS_BASE_URL', 'https://sandbox-pos.smailtek.id'),

    // Production
    // 'base_url' => env('KEDIT_BASE_URL', 'https://admin.sidikty.com'),
    // 'pos_base_url' => env('POS_BASE_URL', 'https://pos.smailtek.id'),
];
