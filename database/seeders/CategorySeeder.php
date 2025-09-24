<?php

namespace Database\Seeders;

use App\Models\Product\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main Categories
        $categories = [
            [
                'name' => 'Electronics',
                'kd_category' => 'ELC',
                'subcategories' => [
                    ['name' => 'Smartphones', 'kd_category' => 'ELC-SP'],
                    ['name' => 'Laptops', 'kd_category' => 'ELC-LP'],
                    ['name' => 'Tablets', 'kd_category' => 'ELC-TB'],
                    ['name' => 'Accessories', 'kd_category' => 'ELC-AC'],
                ]
            ],
            [
                'name' => 'Food & Beverages',
                'kd_category' => 'FNB',
                'subcategories' => [
                    ['name' => 'Snacks', 'kd_category' => 'FNB-SN'],
                    ['name' => 'Beverages', 'kd_category' => 'FNB-BV'],
                    ['name' => 'Instant Food', 'kd_category' => 'FNB-IF'],
                    ['name' => 'Dairy Products', 'kd_category' => 'FNB-DP'],
                ]
            ],
            [
                'name' => 'Fashion',
                'kd_category' => 'FSH',
                'subcategories' => [
                    ['name' => 'Men Clothing', 'kd_category' => 'FSH-MC'],
                    ['name' => 'Women Clothing', 'kd_category' => 'FSH-WC'],
                    ['name' => 'Shoes', 'kd_category' => 'FSH-SH'],
                    ['name' => 'Bags', 'kd_category' => 'FSH-BG'],
                ]
            ],
            [
                'name' => 'Home & Living',
                'kd_category' => 'HNL',
                'subcategories' => [
                    ['name' => 'Furniture', 'kd_category' => 'HNL-FR'],
                    ['name' => 'Kitchen', 'kd_category' => 'HNL-KT'],
                    ['name' => 'Bathroom', 'kd_category' => 'HNL-BT'],
                    ['name' => 'Decoration', 'kd_category' => 'HNL-DC'],
                ]
            ],
            [
                'name' => 'Health & Beauty',
                'kd_category' => 'HNB',
                'subcategories' => [
                    ['name' => 'Skincare', 'kd_category' => 'HNB-SC'],
                    ['name' => 'Makeup', 'kd_category' => 'HNB-MU'],
                    ['name' => 'Personal Care', 'kd_category' => 'HNB-PC'],
                    ['name' => 'Supplements', 'kd_category' => 'HNB-SP'],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'kd_category' => $categoryData['kd_category'],
                'detail' => 'Main category for ' . $categoryData['name'],
                'is_root_parent' => 1,
                'parent_id' => null,
            ]);

            // Create subcategories
            foreach ($categoryData['subcategories'] as $subcat) {
                Category::create([
                    'name' => $subcat['name'],
                    'kd_category' => $subcat['kd_category'],
                    'detail' => 'Subcategory of ' . $categoryData['name'],
                    'is_root_parent' => 0,
                    'parent_id' => $category->id,
                ]);
            }
        }
    }
}
