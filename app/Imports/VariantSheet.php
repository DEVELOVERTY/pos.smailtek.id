<?php

namespace App\Imports;

use App\Models\Product\Product;
use App\Models\Product\Variation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class VariantSheet implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    
    // public function model(array $row)
    // {
    //     $margin = ($row['selling_price'] / $row['purchase_price']) * 100 - 100;
    //     $getMargin = ceil($margin);

    //     $product = Product::where('id', $row['product_id'])->whereNotNull('deleted_at')->first();
    //     $product_exist = Product::where('id', $row['product_id'])->exists();
    //     if ($product) {
    //         return null;
    //     }

    //     if (!$product_exist) {
    //         return null;
    //     }
        
    //     return new Variation(
           
    //             [
    //             // 'id'        => $row['id'],
    //             'product_id'    => $row['product_id'],
    //             'sku'       => $row['sku'],
    //             'price_inc_tax' => $row['purchase_price'],
    //             'purchase_price'    => $row['purchase_price'],
    //             'name'      => $row['name'],
    //             'selling_price' => $row['selling_price'],
    //             'margin'    => $getMargin
    //         ]
    //     );
        


       
    // }


    public function model(array $row)
    {

        if ($row['id'] != null) {
            if (
                $row['product_id'] == null  || $row['purchase_price'] == null || $row['name'] == null || $row['selling_price'] == null
                || $row['unit_id'] == null
            ) {
                Validator::make($row, [
                    'id'        => 'required|unique:variations,id',
                    'product_id'      => 'required',
                    'purchase_price'   => 'required',
                    'name'   => 'required',
                    'selling_price' => 'required',
                    'unit_id'   => 'required'
                ])->validate();
            }

            if ($row['selling_price'] > 0 && $row['purchase_price'] > 0) {

                $margin = ($row['selling_price'] / $row['purchase_price']) * 100 - 100;
                $getMargin = ceil($margin);
                $sku = $row['sku'] ? $row['sku'] : $this->generateEAN();
                // $rak = $row['rak_id'] ? $row['rak_id'] : null;
                // $tax = $row['tax'] ? $row['tax'] : 0;

                return new Variation(
                    [
                        'id'        => $row['id'],
                        'product_id'    => $row['product_id'],
                        'sku'       => $sku,
                        'purchase_price'    => $row['purchase_price'],
                        'name'      => $row['name'],
                        'selling_price' => $row['selling_price'],
                        'margin'    => $getMargin,
                        'unit_id'   => $row['unit_id'],
                    ]
                );
            }
        }
    }

    function generateEAN()
    {
        $code = '200' . str_pad($this->generateRandomCode(), 9, '0');
        $weightflag = true;
        $sum = 0;
        for ($i = strlen($code) - 1; $i >= 0; $i--) {
            $sum += (int)$code[$i] * ($weightflag ? 3 : 1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;
        return $code;
    }

    function generateRandomCode($length = 8)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
