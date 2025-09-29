<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Report Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi cache untuk laporan-laporan dalam aplikasi POS
    | untuk meningkatkan performa loading halaman
    |
    */

    // Cache duration dalam detik
    'cache_duration' => [
        'users' => 300,      // 5 menit - data user jarang berubah
        'stores' => 300,     // 5 menit - data store jarang berubah  
        'customers' => 300,  // 5 menit - data customer jarang berubah
        'products' => 600,   // 10 menit - data produk cukup stabil
        'summary' => 60,     // 1 menit - summary data lebih sering berubah
    ],

    // Cache keys
    'cache_keys' => [
        'users_for_report' => 'users_for_report',
        'stores_for_report' => 'stores_for_report', 
        'customers_for_report' => 'customers_for_report',
        'products_for_report' => 'products_for_report',
    ],

    // Pagination settings
    'pagination' => [
        'per_page' => 20,
        'max_per_page' => 100,
    ],

    // Query optimization settings
    'query_optimization' => [
        'enable_eager_loading' => true,
        'enable_query_caching' => true,
        'enable_summary_optimization' => true,
        'batch_size' => 1000, // untuk batch processing
    ],
];
