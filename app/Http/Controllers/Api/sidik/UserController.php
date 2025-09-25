<?php
namespace App\Http\Controllers\Api\Sidik;

use App\Http\Controllers\Controller;
use App\Models\LogFinger;
use App\Models\Admin\StoreToken;
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
            
            // Return HTML response untuk fingerprint verification
            return response()->view('errors.token-not-configured', [
                'error_message' => 'Token toko tidak dikonfigurasi',
                'instructions' => 'Silakan hubungi admin untuk mengatur token toko di menu Token Toko',
                'transaction_code' => $transactionCode,
                'user_id' => $userId
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
            
            return response()->view('errors.kedit-connection-error', [
                'error_message' => 'Sistem validasi tidak tersedia',
                'details' => $validation['message'],
                'transaction_code' => $transactionCode,
                'user_id' => $userId
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
            
            Log::info('Starting fingerprint verification process', [
                'user_id' => $userId,
                'transaction_code' => $transactionCode,
                'store_token' => $storeToken,
                'kedit_url' => $keditBaseUrl
            ]);
            
            $res = Http::withHeaders([
                "Content-Type" => "application/json",
                "Accept" => "application/json, text-plain, */*",
                "X-Requested-With" => "XMLHttpRequest",
            ])
            ->timeout(10)
            ->get($keditBaseUrl . '/api/user-card/' . $userId . '/fingerprint');
            
            if (!$res->successful()) {
                Log::error('Failed to get fingerprint from Kedit', [
                    'status' => $res->status(),
                    'body' => $res->body(),
                    'url' => $keditBaseUrl . '/api/user-card/' . $userId . '/fingerprint'
                ]);
                throw new \Exception('Failed to get fingerprint: ' . $res->status());
            }
            
            $fingerprintData = $res->json();
            Log::info('Got fingerprint data from Kedit', $fingerprintData);
            
            // Enhanced response with store token and validation data
            $posBaseUrl = config('kedit.pos_base_url');
            $response = $userId . "," . $transactionCode . ';' . $fingerprintData['data'] . 
                       ";SecurityKey;" . $time_limit_ver . ";" . 
                       $posBaseUrl . "/api/user/verify-fingerprint" . ";" . 
                       $keditBaseUrl . "/api/device-ac-sn-by-vc;" . 
                       $storeToken;
            
            Log::info('Sending fingerprint verification response', ['response' => $response]);
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
        try {
            Log::info('Processing fingerprint verification', ['POST_data' => $_POST]);
            
            if (!isset($_POST['VerPas'])) {
                Log::error('VerPas not found in POST data');
                return response()->json(['error' => 'VerPas parameter missing'], 400);
            }
            
            $data = explode(";", $_POST['VerPas']);
            $userId = explode(',', $data[0])[0];
            $transactionCode = explode(',', $data[0])[1];
            $vStamp = $data[1];
            $time = $data[2];
            $sn = $data[3];

            Log::info('Parsed fingerprint verification data', [
                'user_id' => $userId,
                'transaction_code' => $transactionCode,
                'vStamp' => $vStamp,
                'time' => $time,
                'sn' => $sn
            ]);

            $keditBaseUrl = config('kedit.base_url');
            
            // Get fingerprint data
            $res = Http::withHeaders([
                "Content-Type" => "application/json",
                "Accept" => "application/json, text-plain, */*",
                "X-Requested-With" => "XMLHttpRequest",
            ])
            ->timeout(10)
            ->get($keditBaseUrl . '/api/user-card/' . $userId . '/fingerprint');
            
            if (!$res->successful()) {
                Log::error('Failed to get fingerprint from Kedit', [
                    'status' => $res->status(),
                    'body' => $res->body()
                ]);
                return response()->json(['error' => 'Failed to get fingerprint data'], 500);
            }
            
            $fingerprintResponse = $res->json();
            $fingerprint = $fingerprintResponse['data'];
            Log::info('Got fingerprint data', ['fingerprint_length' => strlen($fingerprint)]);

            // Get device data
            $res = Http::withHeaders([
                "Content-Type" => "application/json",
                "Accept" => "application/json, text-plain, */*",
                "X-Requested-With" => "XMLHttpRequest",
            ])
            ->timeout(10)
            ->get($keditBaseUrl . '/api/device/' . $sn);
            
            if (!$res->successful()) {
                Log::error('Failed to get device from Kedit', [
                    'status' => $res->status(),
                    'body' => $res->body(),
                    'sn' => $sn
                ]);
                return response()->json(['error' => 'Failed to get device data'], 500);
            }
            
            $deviceResponse = $res->json();
            $device = $deviceResponse['data'];
            Log::info('Got device data', ['device' => $device]);
            
            // Verify fingerprint
            $salt = md5($sn . $fingerprint . $device['vc'] . $time . $userId . ',' . $transactionCode . $device['vkey']);
            Log::info('Fingerprint verification', [
                'calculated_salt' => strtoupper($salt),
                'received_vStamp' => strtoupper($vStamp),
                'match' => strtoupper($vStamp) == strtoupper($salt)
            ]);
            
            if (strtoupper($vStamp) == strtoupper($salt)) {
                $currentStoreId = session('mystore') ?? 1;
                
                LogFinger::create([
                    'barcode' => 'true',
                    'finger' => 'true',
                    'transaction_code' => $transactionCode,
                    'store_id' => $currentStoreId,
                ]);
                
                Log::info('Fingerprint verification successful', [
                    'transaction_code' => $transactionCode,
                    'user_id' => $userId,
                    'store_id' => $currentStoreId
                ]);
                
                return response()->json(['success' => true, 'message' => 'Fingerprint verified successfully']);
            } else {
                Log::warning('Fingerprint verification failed - salt mismatch', [
                    'transaction_code' => $transactionCode,
                    'user_id' => $userId
                ]);
                return response()->json(['error' => 'Fingerprint verification failed'], 400);
            }
            
        } catch (\Exception $e) {
            Log::error('Exception in processVerifyFingerprint', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Get current store token
     */
    private function getCurrentStoreToken()
    {
        $currentStoreId = session('mystore');
        
        if ($currentStoreId) {
            try {
                $storeToken = StoreToken::where('store_id', $currentStoreId)->first();
                return $storeToken ? $storeToken->token : null;
            } catch (\Exception $e) {
                Log::error('Error accessing store token in UserController: ' . $e->getMessage());
                return null;
            }
        }
        
        // Jika tidak ada store ID di session, coba ambil token pertama yang tersedia
        try {
            $storeToken = StoreToken::first();
            return $storeToken ? $storeToken->token : null;
        } catch (\Exception $e) {
            Log::error('Error accessing any store token in UserController: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Call Kedit validation API
     */
    private function callKeditValidation($userId, $storeToken)
    {
        try {
            $keditBaseUrl = config('kedit.base_url');
            $response = Http::timeout(10)->post($keditBaseUrl . '/api/is-validasi', [
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
