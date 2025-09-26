<?php

use App\Http\Controllers\Api\Pos\PosController;
use App\Http\Controllers\Api\RestController;
use App\Http\Controllers\Api\sidik\TransactionController;
use App\Http\Controllers\Api\sidik\UserController;
use App\Http\Controllers\Admin\StoreTokenController;
use App\Http\Controllers\Api\NotificationController;
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

Route::get('is-transaction-fingerprint-verified/{transactionCode}', [TransactionController::class, 'isTransactionFingerprintVerified']);
Route::get('validate-barcode-for-sidik/{barcode}', [\App\Http\Controllers\Pos\PosController::class, 'validateBarcodeForSidik']);
Route::get('test-sidik-connection', [\App\Http\Controllers\Pos\PosController::class, 'testSidikConnection']);
Route::get('/user/{userId}/verify-fingerprint/{transactionCode}', [UserController::class, 'verifyFingerprint'])->name('user.verify-fingerprint');
Route::post('/user/verify-fingerprint', [UserController::class, 'processVerifyFingerprint'])->name('user.process-verify-fingerprint');

// Store token management routes
Route::get('/admin/store-tokens/generate', [StoreTokenController::class, 'generateToken']);
Route::get('/admin/store-tokens/all', [StoreTokenController::class, 'getAllTokens']);
Route::post('/store-token/sync/{storeId}', [StoreTokenController::class, 'syncWithKedit']);

// Notification routes untuk admin dan kasir
Route::prefix('notifications')->group(function() {
    Route::get('/pending', [NotificationController::class, 'getPendingNotifications']);
    Route::post('/create-error', [NotificationController::class, 'createTransactionError']);
    Route::post('/resolve/{notificationId}', [NotificationController::class, 'resolveNotification']);
    Route::get('/session-errors', function() {
        return response()->json([
            'success' => true,
            'errors' => session('transaction_errors', []),
            'count' => count(session('transaction_errors', []))
        ]);
    });
    Route::post('/clear-session-errors', function() {
        session()->forget('transaction_errors');
        return response()->json(['success' => true, 'message' => 'Session errors cleared']);
    });
});


