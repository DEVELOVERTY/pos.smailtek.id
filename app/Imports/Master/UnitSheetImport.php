<?php

namespace App\Imports\Master;

use App\Models\Product\Unit;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitSheetImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {

        if($row['unit_name'] == null || $row['unit_code'] == null) { 
            Validator::make($row,[
                 'unit_name'    => 'required',
                 'unit_code'    => 'required'
            ])->validate(); 
        }

        return new Unit([
            'id'    => $row['id'],
            'name'  => $row['unit_name'],
            'code'  => $row['unit_code']
        ]);
    }
}
