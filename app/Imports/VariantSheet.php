<?php

namespace App\Imports;

use App\Models\Product\Product;
use App\Models\Product\Variation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VariantSheet implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    
    public function model(array $row)
    {
        $margin = ($row['selling_price'] / $row['purchase_price']) * 100 - 100;
        $getMargin = ceil($margin);

        $product = Product::where('id', $row['product_id'])->whereNotNull('deleted_at')->first();

        if ($product) {
            return null;
        }

        $product_exist = Product::where('id', $row['product_id'])->exists();
        if (!$product_exist) {
            return null;
        }
        
        return new Variation(
           
                [
                // 'id'        => $row['id'],
                'product_id'    => $row['product_id'],
                'sku'       => $row['sku'],
                'price_inc_tax' => $row['purchase_price'],
                'purchase_price'    => $row['purchase_price'],
                'name'      => $row['name'],
                'selling_price' => $row['selling_price'],
                'margin'    => $getMargin
            ]
        );
        


       
    }
}
