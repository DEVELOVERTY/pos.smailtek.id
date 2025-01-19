<?php

namespace App\Imports;

use App\Models\Product\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product\Variation;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductSheet implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
    
    $product = new Product([
        'id' => $row['id'],
        'name' => $row['name'],
        'sku' => $row['sku_product'],
        'type' => $row['type'],
        'category_id' => $row['category'],
        'brand_id' => $row['brand_id'],
        'unit_id' => $row['unit_id'],
        'barcode_type' => $row['barcode_type'],
        'alert_quantity' => $row['alert_quantity'] ?? 0,
        'weight' => $row['weight'] ?? 0,
        'description' => $row['description'] ?? null,
    ]);

    // Save product to database
    $product->save();

    // Handle variations if type is 'single'
    if ($row['type'] == 'single') {
        $variation = new Variation([
            'product_id' => $row['id'],
            'sku' => $row['sku_product'],
            'price_inc_tax' => $row['p_price'],
            'purchase_price' => $row['p_price'],
            'selling_price' => $row['s_price'],
            'margin' => $row['mrg'],
        ]);

        $variation->save();
    }
    }
    
    public function rules(): array
    {
        return [
            'id' => 'required|unique:products,id',
            'name' => 'required',
            'sku_product' => 'required',
            'type' => 'required',
            'category' => 'required',
            'brand_id' => 'required',
            'unit_id' => 'required',
            'barcode_type' => 'required',
            'p_price' => 'required_if:type,single',
            's_price' => 'required_if:type,single',
            'mrg' => 'required_if:type,single',
        ];
        
    }

    private function generateEAN()
    {
        // Your logic to generate an EAN code if necessary
        return 'EAN_' . rand(100000, 999999);
    }

}
