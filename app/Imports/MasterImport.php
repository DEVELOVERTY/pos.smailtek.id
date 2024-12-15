<?php

namespace App\Imports;

use App\Imports\Master\BrandSheetImport;
use App\Imports\Master\UnitSheetImport;
use Illuminate\Support\Collection; 
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterImport implements WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        return [
            0 => new BrandSheetImport(),
            1 => new UnitSheetImport()
        ];
    }
}
