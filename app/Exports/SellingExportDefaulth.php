<?php

namespace App\Exports;

use App\Helper;
use App\Models\Transaction\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SellingExportDefaulth implements FromView
{
    public function __construct()
    {
    }

    public function view(): View
    {
        $data = Transaction::where('type', 'sell')->where("status", "!=", "hold")->where("type", "sell")->orderBy("id", "desc")->get();
        $status = [
            'due'   => __('general.sell_due'),
            "paid"  => __('general.paid'),
            'final' => __('general.paid')
        ];
        $jumlahTotal = 0;
        $jumlahHutang = 0;
        $jumlahTerbayar = 0;
        $jumlahProfit = 0;
        foreach ($data as $d) {
            $jumlahProfit += $d->profit;
            $jumlahTotal += $d->final_total;
            $jumlahHutang += $d->due_total;
            $jumlahTerbayar += Helper::fresh_aprice($d->pay_total);
        }
        return view('admin.export.reports.selling',compact('data','jumlahTotal','jumlahHutang','jumlahTerbayar','status','jumlahProfit'));
    }
}
