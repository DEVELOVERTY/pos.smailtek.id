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

        if ($row['category_code'] == null || $row['subcategory_name'] == null) {
            Validator::make($row, [ 
                'subcategory_name'  => 'required',
                'parent_id' => 'required'
            ])->validate();
        }

        $category = Category::where('kd_category', $row['category_code'])->first();
        if (!$category->count() > 0) {
            return null;
        }else{
            return new Category([
                'name'      => $row['subcategory_name'],
                'is_root_parent'    => 0,
                'parent_id' => $category->id
            ]);
        }
    }
}
