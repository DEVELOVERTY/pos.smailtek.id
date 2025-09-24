<?php

namespace App\Http\Middleware;

use App\Models\Admin\Store;
use App\Models\Admin\StoreToken;
use Closure;
use Illuminate\Http\Request;

class EnsureStoreToken
{
    /**
     * Handle an incoming request.
     * Memastikan setiap toko memiliki token
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil toko yang sedang dipilih
        $currentStoreId = session('mystore');
        
        if ($currentStoreId) {
            $store = Store::find($currentStoreId);
            
            if ($store) {
                // Cek apakah toko sudah memiliki token
                $storeToken = StoreToken::where('store_id', $currentStoreId)->first();
                
                if (!$storeToken) {
                    // Jika belum ada token, buat token otomatis
                    StoreToken::create([
                        'store_id' => $currentStoreId,
                        'token' => $this->generateToken($currentStoreId),
                    ]);
                }
            }
        }
        
        return $next($request);
    }
    
    /**
     * Generate token sederhana berdasarkan store ID
     */
    private function generateToken($storeId)
    {
        return str_pad($storeId * 1111, 5, '0', STR_PAD_LEFT);
    }
}
