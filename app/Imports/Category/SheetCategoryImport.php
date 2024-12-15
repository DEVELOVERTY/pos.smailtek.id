<?php

namespace App\Imports\Category;

use App\Models\Product\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetCategoryImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {

        if ($row['category_name'] == null) {
            Validator::make($row, [
                'category_name'    => 'required'
            ])->validate();
        }

        return new Category([
            'id'        => $row['id'],
            'name'      => $row['category_name'],
            'is_root_parent'    => 1,
        ]);
    }
}
