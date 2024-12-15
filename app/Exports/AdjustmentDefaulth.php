<?php

namespace App\Exports;

use App\Models\Transaction\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class AdjustmentDefaulth implements FromView
{
    public function __construct()
    {
    }

    public function view(): View
    {
        $data = Transaction::where('type', 'stock_adjustment')->orderBy('id', 'desc')->get(); 
        $jumlah = 0;
        foreach($data as $d) {
            $jumlah += $d->total_amount_recovered;
        }
        return view('admin.export.reports.adjustment',compact('data','jumlah'));
    }
}
