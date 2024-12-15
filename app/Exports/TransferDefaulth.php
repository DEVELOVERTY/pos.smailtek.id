<?php

namespace App\Exports;

use App\Models\Transaction\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class TransferDefaulth implements FromView
{
    public function __construct()
    {
    }

    public function view(): View
    {
        $data = Transaction::where('type', 'stock_transfer')->orderBy('id', 'desc')->get();
        $jumlah = 0;
        $status = [
            'transit'   => __('transfer.transit'),
            'complete'  => __('transfer.complete'),
            'pending'   => __('transfer.pending')
        ];
        foreach ($data as $d) {
            $jumlah += $d->final_total;
        }
        return view('admin.export.reports.transfer',compact('data','jumlah','status'));
    }
}
