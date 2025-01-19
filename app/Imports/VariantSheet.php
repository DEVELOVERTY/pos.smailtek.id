<?php

namespace App\Imports;

use App\Models\Product\Product;
use App\Models\Product\Variation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class VariantSheet implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    
    public function model(array $row)
    {
        $margin = ($row['selling_price'] / $row['purchase_price']) * 100 - 100;
        $getMargin = ceil($margin);


        $type_product = Product::where('id', $row['product_id'])->select('type')->first();
        if($type_product == 'single'){
            return null;
        }else{
            return new Variation(
                [
                'product_id'    => $row['product_id'],
                'sku'       => $row['sku_variant'],
                'price_inc_tax' => $row['purchase_price'],
                'purchase_price'    => $row['purchase_price'],
                'name'      => $row['name'],
                'selling_price' => $row['selling_price'],
                'margin'    => $row['margin'] ?? $getMargin,
            ]
        );
        }
        
    }

    public function rules(): array
        {
            return [
                '*.product_id' => 'required|exists:products,id',
                '*.sku_variant' => 'required|string|max:255',
                '*.purchase_price' => 'required|numeric|min:0',
                '*.selling_price' => 'required|numeric|min:0',
                '*.name' => 'required|string|max:255',
                '*.margin' => 'nullable|numeric|min:0',
            ];
        }

        public function customValidationMessages()
        {
            return [
                // '*.product_id.required' => 'Product ID is required.',
                // '*.product_id.exists' => 'Product ID must exist in the products table.',
                '*.sku_variant.required' => 'SKU is required.',
                '*.sku_variant.string' => 'SKU must be a string.',
                '*.sku_variant.max' => 'SKU may not be greater than 255 characters.',
                '*.purchase_price.required' => 'Purchase price is required.',
                '*.purchase_price.numeric' => 'Purchase price must be a number.',
                '*.purchase_price.min' => 'Purchase price must be at least 0.',
                '*.selling_price.required' => 'Selling price is required.',
                '*.selling_price.numeric' => 'Selling price must be a number.',
                '*.selling_price.min' => 'Selling price must be at least 0.',
                '*.name.required' => 'Name is required.',
                '*.name.string' => 'Name must be a string.',
                '*.name.max' => 'Name may not be greater than 255 characters.',
            ];
        }
}
