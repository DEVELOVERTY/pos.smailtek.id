<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use App\Models\Admin\StoreToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StoreTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentStoreId = session('mystore');
        
        if ($currentStoreId) {
            $store = Store::with('storeToken')->findOrFail($currentStoreId);
            
            $stores = collect([$store]);
            $page = 'Token Toko - ' . $store->name; 
        } else {
            $stores = Store::with('storeToken')->get();
            $page = 'Token Toko - Semua Toko';
        }
        
        return view('admin.store-tokens.index', compact('stores', 'currentStoreId', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($storeId)
    {
        $store = Store::findOrFail($storeId);
        $storeToken = StoreToken::where('store_id', $storeId)->first();
        $page = 'Edit Token - ' . $store->name;
        
        return view('admin.store-tokens.edit', compact('store', 'storeToken', 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $storeId)
    {
        $store = Store::findOrFail($storeId);
        
        // Cek apakah store sudah memiliki token
        $existingToken = StoreToken::where('store_id', $storeId)->first();
        
        // Validasi dengan mengecualikan token yang sudah ada untuk store ini
        $validator = Validator::make($request->all(), [
            'token' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9]{5}$/', // Harus 5 digit angka
                function ($attribute, $value, $fail) use ($existingToken) {
                    // Cek apakah token sudah digunakan oleh store lain
                    $tokenExists = StoreToken::where('token', $value)
                        ->when($existingToken, function ($query) use ($existingToken) {
                            return $query->where('id', '!=', $existingToken->id);
                        })
                        ->exists();
                    
                    if ($tokenExists) {
                        $fail('Token sudah digunakan oleh toko lain. Silakan gunakan token yang berbeda.');
                    }
                }
            ],
        ], [
            'token.required' => 'Token wajib diisi.',
            'token.string' => 'Token harus berupa string.',
            'token.max' => 'Token maksimal 20 karakter.',
            'token.regex' => 'Token harus berupa 5 digit angka (contoh: 12345).',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update or create token
        StoreToken::updateOrCreate(
            ['store_id' => $storeId],
            ['token' => $request->token]
        );

        return redirect()->route('admin.store-tokens.index')
            ->with('success', 'Token untuk toko ' . $store->name . ' berhasil diperbarui.');
    }

    /**
     * Generate random token
     */
    public function generateToken()
    {
        try {
            $maxAttempts = 100; // Maksimal 100 percobaan untuk mencegah infinite loop
            $attempts = 0;
            
            do {
                // Generate random 5-digit token
                $token = str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
                $attempts++;
                
                // Cek apakah token sudah ada di database menggunakan helper method
                $isUnique = $this->isTokenUnique($token);
                
                // Jika sudah mencapai maksimal percobaan
                if ($attempts >= $maxAttempts) {
                    throw new \Exception('Tidak dapat generate token unik setelah ' . $maxAttempts . ' percobaan. Database mungkin sudah penuh dengan token.');
                }
                
            } while (!$isUnique);
            
            return response()->json([
                'success' => true,
                'token' => $token,
                'message' => 'Token berhasil di-generate (percobaan ke-' . $attempts . ')',
                'attempts' => $attempts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate token: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if token is unique in database and Kedit system
     */
    private function isTokenUnique($token, $excludeStoreTokenId = null)
    {
        // Check local database
        $query = StoreToken::where('token', $token);
        
        if ($excludeStoreTokenId) {
            $query->where('id', '!=', $excludeStoreTokenId);
        }
        
        $localExists = $query->exists();
        
        // Check Kedit system
        $keditExists = $this->checkTokenInKedit($token);
        
        return !($localExists || $keditExists);
    }
    
    /**
     * Check if token exists in Kedit system
     */
    private function checkTokenInKedit($token)
    {
        try {
            $keditBaseUrl = config('kedit.base_url');
            $response = Http::timeout(5)->get($keditBaseUrl . '/api/merchant/check-token/' . $token);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['exists'] ?? false;
            }
            
            return false;
        } catch (\Exception $e) {
            // If Kedit system is unavailable, log warning and continue with local validation
            Log::warning('Cannot connect to Kedit system for token validation: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all existing tokens for debugging
     */
    public function getAllTokens()
    {
        if (config('app.debug')) {
            $tokens = StoreToken::with('store')->get(['id', 'store_id', 'token']);
            return response()->json([
                'success' => true,
                'tokens' => $tokens,
                'count' => $tokens->count()
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'Debug mode only'], 403);
    }

    /**
     * Sync store token with Kedit system
     */
    public function syncWithKedit($storeId)
    {
        try {
            $store = Store::findOrFail($storeId);
            $storeToken = StoreToken::where('store_id', $storeId)->first();
            
            if (!$storeToken) {
                return response()->json(['error' => 'Store token not found'], 404);
            }
            
            // Sync dengan Kedit system
            $keditBaseUrl = config('kedit.base_url');
            $response = Http::timeout(10)->post($keditBaseUrl . '/api/merchant/sync-token', [
                'store_id' => $storeId,
                'store_name' => $store->name,
                'token' => $storeToken->token,
                'sync_source' => 'pos_system'
            ]);
            
            if ($response->successful()) {
                $responseData = $response->json();
                
                // Update status sinkronisasi (jika ada field ini)
                // $storeToken->update(['synced_with_kedit' => true]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Token berhasil disinkronisasi dengan Kedit system',
                    'kedit_merchant_id' => $responseData['merchant_id'] ?? null,
                    'kedit_response' => $responseData
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $response->body(),
                'status_code' => $response->status()
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sync error: ' . $e->getMessage()
            ], 500);
        }
    }

}
