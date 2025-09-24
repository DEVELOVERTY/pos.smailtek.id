<?php

namespace Database\Seeders;

use App\Models\Product\Product;
use App\Models\Product\Variation;
use App\Models\Product\Stock;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            // Electronics - Smartphones
            [
                'category_id' => 2, // Smartphones subcategory
                'brand_id' => 1, // Samsung
                'unit_id' => 1, // Piece
                'name' => 'Samsung Galaxy A54 5G',
                'description' => 'Samsung Galaxy A54 5G 8GB/128GB',
                'barcode' => '8801643670825',
                'buy_price' => 4500000,
                'sell_price' => 5200000,
                'stock_qty' => 25,
            ],
            [
                'category_id' => 2, // Smartphones subcategory
                'brand_id' => 2, // Apple
                'unit_id' => 1, // Piece
                'name' => 'iPhone 14',
                'description' => 'Apple iPhone 14 128GB',
                'barcode' => '194253404675',
                'buy_price' => 12000000,
                'sell_price' => 13500000,
                'stock_qty' => 15,
            ],
            [
                'category_id' => 2, // Smartphones subcategory
                'brand_id' => 6, // Xiaomi
                'unit_id' => 1, // Piece
                'name' => 'Xiaomi Redmi Note 12',
                'description' => 'Xiaomi Redmi Note 12 6GB/128GB',
                'barcode' => '6934177780851',
                'buy_price' => 2200000,
                'sell_price' => 2650000,
                'stock_qty' => 40,
            ],

            // Electronics - Laptops
            [
                'category_id' => 3, // Laptops subcategory
                'brand_id' => 2, // Apple
                'unit_id' => 1, // Piece
                'name' => 'MacBook Air M2',
                'description' => 'Apple MacBook Air M2 13-inch 8GB/256GB',
                'barcode' => '194253081470',
                'buy_price' => 16000000,
                'sell_price' => 18500000,
                'stock_qty' => 8,
            ],
            [
                'category_id' => 3, // Laptops subcategory
                'brand_id' => 1, // Samsung (using Samsung for variety)
                'unit_id' => 1, // Piece
                'name' => 'ASUS VivoBook 14',
                'description' => 'ASUS VivoBook 14 Intel Core i5 8GB/512GB SSD',
                'barcode' => '4711081761457',
                'buy_price' => 7500000,
                'sell_price' => 8750000,
                'stock_qty' => 12,
            ],

            // Food & Beverages - Snacks
            [
                'category_id' => 6, // Snacks subcategory
                'brand_id' => 15, // Indofood
                'unit_id' => 1, // Piece
                'name' => 'Indomie Goreng',
                'description' => 'Indomie Mi Goreng Original 85g',
                'barcode' => '8992388101015',
                'buy_price' => 2500,
                'sell_price' => 3500,
                'stock_qty' => 200,
            ],
            [
                'category_id' => 6, // Snacks subcategory
                'brand_id' => 15, // Indofood
                'unit_id' => 1, // Piece
                'name' => 'Chitato Sapi Panggang',
                'description' => 'Chitato Keripik Kentang Rasa Sapi Panggang 68g',
                'barcode' => '8992388102234',
                'buy_price' => 8000,
                'sell_price' => 11000,
                'stock_qty' => 150,
            ],

            // Food & Beverages - Beverages
            [
                'category_id' => 7, // Beverages subcategory
                'brand_id' => 13, // Coca Cola
                'unit_id' => 1, // Piece
                'name' => 'Coca Cola 330ml',
                'description' => 'Coca Cola Original Taste 330ml Can',
                'barcode' => '8999999047108',
                'buy_price' => 4500,
                'sell_price' => 7000,
                'stock_qty' => 100,
            ],
            [
                'category_id' => 7, // Beverages subcategory
                'brand_id' => 12, // Nestle
                'unit_id' => 1, // Piece
                'name' => 'Milo UHT 200ml',
                'description' => 'Nestle Milo UHT Chocolate Malt Drink 200ml',
                'barcode' => '8999999512347',
                'buy_price' => 3500,
                'sell_price' => 5500,
                'stock_qty' => 80,
            ],

            // Health & Beauty - Skincare
            [
                'category_id' => 18, // Skincare subcategory
                'brand_id' => 11, // Unilever
                'unit_id' => 1, // Piece
                'name' => 'Pond\'s Age Miracle',
                'description' => 'Pond\'s Age Miracle Day Cream 50g',
                'barcode' => '8999999036287',
                'buy_price' => 35000,
                'sell_price' => 52000,
                'stock_qty' => 30,
            ],

            // Fashion - Men Clothing
            [
                'category_id' => 10, // Men Clothing subcategory
                'brand_id' => 1, // Using Samsung as generic brand
                'unit_id' => 1, // Piece
                'name' => 'Kemeja Pria Formal',
                'description' => 'Kemeja Pria Lengan Panjang Formal Putih Size M',
                'barcode' => '1234567890123',
                'buy_price' => 75000,
                'sell_price' => 125000,
                'stock_qty' => 20,
            ],
        ];

        foreach ($products as $productData) {
            // Create product
            $product = Product::create([
                'category_id' => $productData['category_id'],
                'brand_id' => $productData['brand_id'],
                'unit_id' => $productData['unit_id'],
                'name' => $productData['name'],
                'sku' => $productData['barcode'],
                'type' => 'single', // single product type
                'barcode_type' => 'CODE128',
                'description' => $productData['description'],
                'alert_quantity' => 10,
            ]);

            // Create variation for the product
            $variation = Variation::create([
                'product_id' => $product->id,
                'sku' => $productData['barcode'],
                'name' => $productData['name'],
                'purchase_price' => $productData['buy_price'],
                'selling_price' => $productData['sell_price'],
                'price_inc_tax' => $productData['sell_price'],
                'margin' => (($productData['sell_price'] - $productData['buy_price']) / $productData['buy_price'] * 100),
            ]);

            // Create initial stock entry
            Stock::create([
                'product_id' => $product->id,
                'variation_id' => $variation->id,
                'store_id' => 1, // Default store
                'qty_available' => $productData['stock_qty'],
            ]);
        }
    }
}
