<?php

namespace Database\Seeders;

use App\Models\Admin\Store;
use App\Models\Admin\StoreToken;
use Illuminate\Database\Seeder;

class StoreTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all stores
        $stores = Store::all();

        // Predefined simple tokens
        $tokens = [
            '54321', // Default token seperti yang diminta
            '12345',
            '67890',
            '11111',
            '22222',
            '33333',
            '44444',
            '55555',
        ];

        foreach ($stores as $index => $store) {
            // Use predefined token or generate simple one
            $token = $tokens[$index] ?? $this->generateSimpleToken($store->id);
            
            StoreToken::create([
                'store_id' => $store->id,
                'token' => $token,
            ]);
        }
    }

    /**
     * Generate simple token based on store ID
     */
    private function generateSimpleToken($storeId)
    {
        // Generate simple 5-digit token
        return str_pad($storeId * 1111, 5, '0', STR_PAD_LEFT);
    }
}
