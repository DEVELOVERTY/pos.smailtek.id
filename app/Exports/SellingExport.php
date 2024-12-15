<?php

namespace App\Exports;

use App\Models\Transaction\Transaction as TransactionTransaction;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SellingExport implements FromView
{
    public function __construct(Request $request)
    {
        // $this->start    = $start;
        // $this->year    = $year;
    }

    public function view(): View
    {

        return view('laporan.excel.defaulth', [
            'data' => TransactionTransaction::where('')->where('bulan',$this->start)->where('tahun_id', $this->year)->get()
        ]);
       
    }
   
}
