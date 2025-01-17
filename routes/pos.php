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
    Route::prefix('product')->group(function () {
        Route::get('/index', [PosController::class, 'product']);
        Route::get('/category/{id}', [PosController::class, 'byCategory']);
        Route::get('get-bill/{id}',[PosController::class,'getbill']);
        Route::get('delete-bill/{id}',[PosController::class,'deleteBill']);
    });

    

});

// verify
Route::middleware(['auth'])->group(function () {
    Route::get('/user/{userId}/verify-fingerprint/{transactionCode}', [UserController::class, 'verifyFingerprint'])->name('user.verify-fingerprint');
    Route::post('/user/verify-fingerprint', [UserController::class, 'processVerifyFingerprint'])->name('user.process-verify-fingerprint');
});
