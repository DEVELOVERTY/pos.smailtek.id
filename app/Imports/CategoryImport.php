<?php

namespace App\Imports;

use App\Imports\Category\SecondSheetCategoryImport;
use App\Imports\Category\SheetCategoryImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CategoryImport implements WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        return [
            0   => new SheetCategoryImport(),
            1   => new SecondSheetCategoryImport()
        ];
    }
}
