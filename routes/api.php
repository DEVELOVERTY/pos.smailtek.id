<?php

use App\Http\Controllers\Api\Pos\PosController;
use App\Http\Controllers\Api\RestController;
use App\Http\Controllers\Api\Sidik\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('transaction')->group(function() {
    Route::get("/get-invoice/{id}",[RestController::class,'getInvoice']);
    Route::get('print-invoice-rest/{id}',[RestController::class,'printInvoice'])->name('print-invoice-rest');
});

Route::get('is-transaction-fingerprint-verified', [TransactionController::class, 'isTransactionFingerprintVerified']);



