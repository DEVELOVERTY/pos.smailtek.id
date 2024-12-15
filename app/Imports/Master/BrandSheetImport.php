<?php

namespace App\Imports\Master;

use App\Models\Product\Brand;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BrandSheetImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
      
       if($row['brand_code'] == null || $row['brand_name'] == null) { 
           Validator::make($row,[
                'brand_code'    => 'required',
                'brand_name'    => 'required'
           ])->validate(); 
       }
      
        return new Brand([
            'id'    => $row['id'],
            'name'  => $row['brand_name'],
            'code'  => $row['brand_code']
        ]);
    }
}
