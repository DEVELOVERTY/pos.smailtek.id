<?php

use App\Http\Controllers\Api\Sidik\UserController;
use App\Http\Controllers\Pos\PosController;
use App\Http\Controllers\Transaction\SellController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','store'])->group(function () {
    Route::get('/layer', [PosController::class, 'index'])->name('pos.index');
    Route::post('store', [SellController::class, 'store'])->name('pos.store');
    Route::get('getProduct/{id}', [PosController::class, 'getProduct']);
    Route::get('get-customer',[PosController::class,'customer']);
    Route::get('get-hold',[PosController::class,'getHold']);
    Route::get('print/{id}',[PosController::class,'printReceipt'])->name('print.receipt');
    Route::post('get-user-by-barcode', [PosController::class, 'getUserByBarcode']);
    Route::post('validate-user', [PosController::class, 'validateUser']);
    Route::get('test-kedit-connection', [PosController::class, 'testKeditConnection']);
    Route::post('sync-current-store-token', [PosController::class, 'syncCurrentStoreToken']);
    Route::get('validate-token-sync', [PosController::class, 'validateTokenSync']);
    Route::get('check-current-store-token-status', [PosController::class, 'checkCurrentStoreTokenStatus']);
    Route::post('auto-setup-token-for-debugging', [PosController::class, 'autoSetupTokenForDebugging']);
    Route::get('debug-payment-process', [PosController::class, 'debugPaymentProcess']);
    Route::prefix('product')->group(function () {
        Route::get('/index', [PosController::class, 'product']);
        Route::get('/category/{id}', [PosController::class, 'byCategory']);
        Route::get('get-bill/{id}',[PosController::class,'getbill']);
        Route::get('delete-bill/{id}',[PosController::class,'deleteBill']);
    });

    

});
