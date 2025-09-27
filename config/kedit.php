<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kedit System Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi URL akan dipilih otomatis berdasarkan MODE di .env:
    | - MODE=testing  -> localhost URLs
    | - MODE=sandbox  -> sandbox URLs  
    | - MODE=production -> production URLs
    |
    */
    
    'base_url' => match(env('MODE', 'testing')) {
        'testing' => env('KEDIT_BASE_URL', 'http://127.0.0.1:8000'),
        'sandbox' => env('KEDIT_BASE_URL', 'https://sandbox-sidik.smailtek.id'),
        'production' => env('KEDIT_BASE_URL', 'https://admin.sidikty.com'),
        default => env('KEDIT_BASE_URL', 'http://127.0.0.1:8000')
    },
    
    'pos_base_url' => match(env('MODE', 'testing')) {
        'testing' => env('POS_BASE_URL', 'http://127.0.0.1:8001'),
        'sandbox' => env('POS_BASE_URL', 'https://sandbox-pos.smailtek.id'),
        'production' => env('POS_BASE_URL', 'https://pos.smailtek.id'),
        default => env('POS_BASE_URL', 'http://127.0.0.1:8001')
    },
];
