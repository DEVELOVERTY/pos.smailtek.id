<?php

namespace App\Imports;

use App\Models\Product\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class ProductSheet implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    // public function model(array $row)
    // {
        
    //     // Check if a product with the same id already exists
    //     if (Product::where('id', $row['id'])->exists()) {
    //         return null; // Skip this row
    //     }

    //     return new Product([
    //         'id'            => $row['id'],
    //         'name'          => $row['product_name'],
    //         'sku'           => $row['sku'],
    //         'barcode_type'  => $row['barcode_type'],
    //         'category_id'   => $row['category_id'],
    //         'brand_id'      => $row['brand_id'],
    //         'unit_id'       => $row['unit_id'],
    //         'alert_quantity'    => $row['alert_qty'],
    //         'type'          => $row['product_type']
    //     ]);
    // }


    public function model(array $row)
    {
        if ($row['id'] != null) {
            if ($row['product_name'] == null || $row['sku'] == null || $row['barcode_type'] == null || $row['category_id'] == null || $row['alert_qty'] == null  || $row['product_type'] == null) {
                Validator::make($row, [
                    'id'        => 'required|unique:products,id',
                    'product_name'    => 'required',
                    'sku'    => 'required',
                    'barcode_type'    => 'required',
                    'category_id'    => 'required',
                    'alert_qty'    => 'required',
                    'product_type'    => 'required'
                ])->validate();
            }

            $brand = $row['brand_id'] ? $row['brand_id'] : null;

            return new Product([
                'id'            => $row['id'],
                'name'          => $row['product_name'],
                'sku'           => $row['sku'],
                'barcode_type'  => $row['barcode_type'],
                'category_id'   => $row['category_id'],
                'brand_id'      => $brand,
                'alert_quantity'    => $row['alert_qty'],
                'type'          => $row['product_type']
            ]);
        }
    }
}
