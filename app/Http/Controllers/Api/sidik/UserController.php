<?php

namespace App\Http\Controllers\Api\Sidik;

use App\Http\Controllers\Controller;
use App\Models\LogFinger;
use App\Models\Admin\StoreToken;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;


class UserController extends Controller
{
    public function verifyFingerprint($userId, $transactionCode)
    {
        // Get store token
        $storeToken = $this->getCurrentStoreToken();
        
        if (!$storeToken) {
            $this->createTransactionError([
                'error_type' => 'token_not_found',
                'error_message' => 'Store token tidak dikonfigurasi untuk toko ini',
                'transaction_code' => $transactionCode,
                'user_id' => $userId,
                'store_token' => null,
                'details' => [
                    'store_id' => session('mystore'),
                    'action' => 'verify_fingerprint'
                ]
            ]);
            
            return response()->json([
                'error' => 'TRANSAKSI DIHENTIKAN: Token toko tidak dikonfigurasi',
                'error_code' => 'TOKEN_NOT_CONFIGURED',
                'message' => 'Silakan hubungi admin untuk konfigurasi token toko',
                'requires_admin' => true,
                'severity' => 'high'
            ], 400);
        }
        
        // Validate with Kedit system first
        $validation = $this->callKeditValidation($userId, $storeToken);
        
        if ($validation['status'] === 'error') {
            $this->createTransactionError([
                'error_type' => 'kedit_connection_error',
                'error_message' => 'Gagal terhubung ke sistem Kedit untuk validasi user',
                'transaction_code' => $transactionCode,
                'user_id' => $userId,
                'store_token' => $storeToken,
                'details' => [
                    'kedit_error' => $validation['message'],
                    'action' => 'user_validation'
                ]
            ]);
            
            return response()->json([
                'error' => 'TRANSAKSI DIHENTIKAN: Sistem validasi tidak tersedia',
                'error_code' => 'KEDIT_CONNECTION_ERROR',
                'message' => 'Silakan hubungi admin - sistem Kedit tidak dapat diakses',
                'details' => $validation['message'],
                'requires_admin' => true,
                'severity' => 'high'
            ], 500);
        }
        
        // Check validation results
        $validationData = $validation['data'];
        
        // Check if user can proceed with transaction
        if (!($validationData['can_proceed'] ?? true)) {
            $errorMessage = 'Transaksi tidak dapat dilanjutkan';
            $errorType = 'transaction_validation_failed';
            
            if ($validationData['status'] === 'Belum Lunas') {
                $errorMessage = 'User memiliki tagihan yang belum lunas sebesar Rp ' . number_format($validationData['jumlah']);
                $errorType = 'unpaid_bills';
            } elseif ($validationData['limit_status'] === 'aktif' && is_numeric($validationData['sisa_limit']) && $validationData['sisa_limit'] <= 0) {
                $errorMessage = 'Limit harian habis. Limit: Rp ' . number_format($validationData['limit_harian']);
                $errorType = 'limit_exceeded';
            }
            
            $this->createTransactionError([
                'error_type' => $errorType,
                'error_message' => $errorMessage,
                'transaction_code' => $transactionCode,
                'user_id' => $userId,
                'store_token' => $storeToken,
                'details' => [
                    'validation_data' => $validationData,
                    'action' => 'user_validation_check'
                ]
            ]);
            
            return response()->json([
                'error' => 'TRANSAKSI DIHENTIKAN: ' . $errorMessage,
                'error_code' => strtoupper($errorType),
                'message' => $errorType === 'unpaid_bills' ? 
                    'User harus melunasi tagihan terlebih dahulu' : 
                    'Hubungi admin untuk penyesuaian limit atau tunggu hari berikutnya',
                'validation_data' => $validationData,
                'requires_admin' => $errorType === 'limit_exceeded',
                'severity' => 'medium'
            ], 400);
        }
        
        // If validation passed, proceed with fingerprint verification
        $time_limit_ver = 15;
        try {
            $keditBaseUrl = config('kedit.base_url');
            $res = Http::withHeaders([
                "Content-Type" => "application/json",
                "Accept" => "application/json, text-plain, */*",
                "X-Requested-With" => "XMLHttpRequest",
            ])
            ->timeout(10)
            ->get($keditBaseUrl . '/api/user-card/' . $userId . '/fingerprint')
            ->json();
            
            // Enhanced response with store token and validation data
            $posBaseUrl = config('kedit.pos_base_url');
            $response = $userId . "," . $transactionCode . ';' . $res['data'] . 
                       ";SecurityKey;" . $time_limit_ver . ";" . 
                       $posBaseUrl . "/api/user/verify-fingerprint" . ";" . 
                       $keditBaseUrl . "/api/device-ac-sn-by-vc;" . 
                       $storeToken;
            
            echo $response;
            
        } catch (\Exception $e) {
            Log::error('Fingerprint verification failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Cannot connect to Kedit system for fingerprint data',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function processVerifyFingerprint()
    {
        $data = explode(";", $_POST['VerPas']);
        $userId = explode(',', $data[0])[0];
        $transactionCode = explode(',', $data[0])[1];
        $vStamp = $data[1];
        $time = $data[2];
        $sn = $data[3];

        $keditBaseUrl = config('kedit.base_url');
        $res = Http::withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json, text-plain, */*",
            "X-Requested-With" => "XMLHttpRequest",
        ])
            // ->timeout(10)
            ->get($keditBaseUrl . '/api/user-card/' . $userId . '/fingerprint')
            ->json();
            

        $fingerprint = $res['data'];

        Log::debug($fingerprint);

        $res = Http::withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json, text-plain, */*",
            "X-Requested-With" => "XMLHttpRequest",
        ])
        // ->timeout(10)
        ->get($keditBaseUrl . '/api/device/' . $sn)
        ->json();

        $device = $res['data'];
        Log::debug($device);
        $salt = md5($sn . $fingerprint . $device['vc'] . $time . $userId . ',' . $transactionCode . $device['vkey']);
        if (strtoupper($vStamp) == strtoupper($salt)) {
            // Transaction::where('id', $barcode)->update([
            //     'is_fingerprint_verified' => true,
            // ]);

            LogFinger::create([
                'barcode' => 'true',
                'finger' => 'true',
                'transaction_code' => $transactionCode,
                'store_id' => 1001,
            ]);
           
        } else {
            Log::debug('invalid fingerprint');
        }
    }

    /**
     * Get current store token
     */
    private function getCurrentStoreToken()
    {
        $currentStoreId = session('mystore');
        
        if ($currentStoreId) {
            $storeToken = StoreToken::where('store_id', $currentStoreId)->first();
            return $storeToken ? $storeToken->token : null;
        }
        
        // Fallback: get first available token (for testing)
        $storeToken = StoreToken::first();
        return $storeToken ? $storeToken->token : null;
    }

    /**
     * Call Kedit validation API
     */
    private function callKeditValidation($userId, $storeToken)
    {
        try {
            $keditBaseUrl = config('kedit.base_url');
            $response = Http::timeout(10)->post($keditBaseUrl . '/api/user-card/is-validasi', [
                'id_user_card' => $userId,
                'token_mart' => $storeToken
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return [
                'status' => 'error',
                'message' => 'Kedit system validation failed: ' . $response->body()
            ];
        } catch (\Exception $e) {
            Log::error('Kedit validation error: ' . $e->getMessage());
            
            return [
                'status' => 'error',
                'message' => 'Cannot connect to Kedit system: ' . $e->getMessage()
            ];
        }
    }


    /**
     * Create transaction error notification
     */
    private function createTransactionError($errorData)
    {
        try {
            // Add timestamp and session info
            $errorData['timestamp'] = now()->toISOString();
            $errorData['store_id'] = session('mystore');
            $errorData['cashier_session'] = session()->getId();
            $errorData['severity'] = $this->determineSeverity($errorData['error_type']);
            $errorData['requires_admin'] = $this->requiresAdmin($errorData['error_type']);
            $errorData['status'] = 'pending';

            // Store in cache for real-time access
            $notificationId = 'transaction_error_' . uniqid();
            Cache::put($notificationId, $errorData, now()->addHours(24));

            // Store notification ID in cache list
            $notificationKeys = Cache::get('notification_keys', []);
            $notificationKeys[] = $notificationId;
            Cache::put('notification_keys', $notificationKeys, now()->addHours(24));

            // Store in session for current user
            $sessionErrors = session('transaction_errors', []);
            $sessionErrors[] = $errorData;
            session(['transaction_errors' => $sessionErrors]);

            // Log for admin monitoring
            Log::channel('single')->error('Transaction Error', $errorData);

            return $notificationId;
        } catch (\Exception $e) {
            Log::error('Failed to create transaction error notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Determine error severity
     */
    private function determineSeverity($errorType)
    {
        $severityMap = [
            'invalid_token' => 'high',
            'token_not_found' => 'high',
            'user_not_found' => 'medium',
            'user_inactive' => 'medium',
            'limit_exceeded' => 'medium',
            'unpaid_bills' => 'medium',
            'kedit_connection_error' => 'high',
            'fingerprint_verification_failed' => 'medium',
            'transaction_validation_failed' => 'high'
        ];

        return $severityMap[$errorType] ?? 'medium';
    }

    /**
     * Check if error requires admin intervention
     */
    private function requiresAdmin($errorType)
    {
        $adminRequired = [
            'invalid_token',
            'token_not_found', 
            'kedit_connection_error',
            'transaction_validation_failed'
        ];

        return in_array($errorType, $adminRequired);
    }
}
