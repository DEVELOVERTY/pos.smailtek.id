<?php

namespace App\Exports;

use App\Models\Transaction\Transaction;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ReturnExportDefaulth implements FromView
{
    public function __construct()
    {
    }

    public function view(): View
    {
        $data = Transaction::where('type', 'purchase_return')->orderBy('id', 'desc')->get();
        $jumlahTotal = 0;
        $jumlahHutang = 0; 
        foreach ($data as $d) {
            $jumlahTotal += $d->final_total;
            $jumlahHutang += $d->due_total ?? $d->final_total; 
        }
        return view('admin.export.reports.return',compact('data','jumlahTotal','jumlahHutang'));
    }
}
