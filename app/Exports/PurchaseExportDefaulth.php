<?php

namespace App\Exports;

use App\Helper;
use App\Models\Transaction\Transaction;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PurchaseExportDefaulth implements FromView
{
    public function __construct()
    {
    }

    public function view(): View
    {
        $data = Transaction::where('type', 'purchase')->orderBy('id', 'desc')->get();
        $jumlahTotal = 0;
        $jumlahHutang = 0;
        $jumlahTerbayar = 0;
        foreach ($data as $d) {
            $jumlahTotal += $d->final_total;
            $jumlahHutang += $d->due_total;
            $jumlahTerbayar += Helper::fresh_aprice($d->pay_total);
        }

        $status = [
            'received'      => __('purchase.received'),
            'ordered'       => __('purchase.ordered'),
            'pending'       => __('purchase.pending')
        ];

        $payment = [
            'due'   => __('general.po_due'),
            'paid'  => __('general.paid')
        ];
        return view('admin.export.reports.purchase',compact('data','jumlahTotal','jumlahHutang','jumlahTerbayar','status','payment'));
    }
}
