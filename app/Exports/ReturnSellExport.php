<?php

namespace App\Exports;

use App\Models\Transaction\Transaction; 
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class ReturnSellExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
    }

    public function view(): View
    {
        $data = Transaction::where('type', 'sales_return')->orderBy('id', 'desc')->get(); 
        return view('admin.export.reports.returnsell',compact('data'));
    }
}
