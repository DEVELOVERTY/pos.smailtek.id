<?php

namespace App\Imports\Category;

use App\Models\Product\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SecondSheetCategoryImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {

        if ($row['parent_id'] == null || $row['subcategory_name'] == null) {
            Validator::make($row, [ 
                'subcategory_name'  => 'required',
                'parent_id' => 'required'
            ])->validate();
        }

        return new Category([
            'id'        => $row['id'],
            'name'      => $row['subcategory_name'],
            'is_root_parent'    => 0,
            'parent_id' => $row['category_id']
        ]);
    }
}
