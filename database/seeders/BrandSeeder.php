<?php

namespace Database\Seeders;

use App\Models\Product\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['name' => 'Samsung', 'code' => 'SAMSUNG', 'detail' => 'Electronics and Technology'],
            ['name' => 'Apple', 'code' => 'APPLE', 'detail' => 'Technology and Innovation'],
            ['name' => 'Sony', 'code' => 'SONY', 'detail' => 'Electronics and Entertainment'],
            ['name' => 'LG', 'code' => 'LG', 'detail' => 'Home Appliances and Electronics'],
            ['name' => 'Panasonic', 'code' => 'PANASONIC', 'detail' => 'Electronics and Appliances'],
            ['name' => 'Xiaomi', 'code' => 'XIAOMI', 'detail' => 'Smart Technology'],
            ['name' => 'Oppo', 'code' => 'OPPO', 'detail' => 'Mobile Technology'],
            ['name' => 'Vivo', 'code' => 'VIVO', 'detail' => 'Mobile Technology'],
            ['name' => 'Realme', 'code' => 'REALME', 'detail' => 'Mobile Technology'],
            ['name' => 'Huawei', 'code' => 'HUAWEI', 'detail' => 'Technology and Telecommunications'],
            ['name' => 'Unilever', 'code' => 'UNILEVER', 'detail' => 'Consumer Goods'],
            ['name' => 'Nestle', 'code' => 'NESTLE', 'detail' => 'Food and Beverages'],
            ['name' => 'Coca Cola', 'code' => 'COCACOLA', 'detail' => 'Beverages'],
            ['name' => 'Pepsi', 'code' => 'PEPSI', 'detail' => 'Beverages'],
            ['name' => 'Indofood', 'code' => 'INDOFOOD', 'detail' => 'Food Products'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
