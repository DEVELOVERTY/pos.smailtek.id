<?php

namespace App\Exports;

use App\Helper;
use App\Models\Transaction\Transaction;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class DueBookDefaulth implements FromView
{
    public function __construct()
    {
    }

    public function view(): View
    {
        $data =  Transaction::where('type', 'sell')->where('payment_status', 'due')->where('status', 'due')->orderBy('id', 'desc')->get();
       
        $jumlahTotal = 0;
        $jumlahHutang = 0;
        $jumlahTerbayar = 0;
        foreach ($data as $d) {
            $jumlahTotal += $d->final_total;
            $jumlahHutang += $d->due_total;
            $jumlahTerbayar += Helper::fresh_aprice($d->pay_total);
        }
        return view('admin.export.reports.due',compact('data','jumlahTotal','jumlahHutang','jumlahTerbayar'));
    }
}
