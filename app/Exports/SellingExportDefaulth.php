<?php

namespace App\Exports;

use App\Helper;
use App\Models\Transaction\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class SellingExportDefaulth implements FromView
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        // Query yang sama persis dengan controller
        $query = Transaction::select(
                'transactions.*',
                DB::raw('COALESCE(SUM(transaction_payments.amount),0) as pay_total'),
                DB::raw('(transactions.final_total - COALESCE(SUM(transaction_payments.amount),0)) as due_total'),
                DB::raw('MAX(transaction_payments.method) as method')
            )
            ->leftJoin('transaction_payments', 'transactions.id', '=', 'transaction_payments.transaction_id')
            ->where('transactions.type', 'sell')
            ->where('transactions.status', '!=', 'hold')
            ->whereNull('transactions.deleted_at')
            ->groupBy('transactions.id')
            ->orderBy('transactions.id', 'desc');

        // Terapkan filter yang sama seperti di controller
        if (!empty($this->filters['store'])) {
            $query->where('transactions.store_id', $this->filters['store']);
        }
        if (!empty($this->filters['customer'])) {
            $query->where('transactions.customer_id', $this->filters['customer']);
        }
        if (!empty($this->filters['payment'])) {
            $query->where('transactions.payment_status', $this->filters['payment']);
        }
        if (!empty($this->filters['createdby'])) {
            $query->where('transactions.created_by', $this->filters['createdby']);
        }
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('transactions.created_at', [$this->filters['start_date'], $this->filters['end_date']]);
        }
        
        // Filter berdasarkan metode pembayaran - sama seperti di controller
        if (!empty($this->filters['payment_method'])) {
            $query->whereHas('payment', function($q) {
                $q->where('method', $this->filters['payment_method']);
            });
        }

        $data = $query->with(['store:id,name', 'customer:id,name', 'createdby:id,name', 'sell'])
                     ->get();
        $status = [
            'due'   => __('general.sell_due'),
            "paid"  => __('general.paid'),
            'final' => __('general.paid')
        ];
        $jumlahTotal = 0;
        $jumlahHutang = 0;
        $jumlahTerbayar = 0;
        $jumlahProfit = 0;
        
        // Transform data - data method, pay_total, due_total sudah disiapkan oleh query SQL
        foreach ($data as $item) {
            // Set default untuk field yang belum ada
            $item->qty_sell = 0;
            $item->calculated_profit = 0;
            
            // Pastikan method tidak null (jika null, default ke cash)
            if (empty($item->method)) {
                $item->method = 'cash';
            }
            
            // Hitung qty_sell dari relasi sell
            if ($item->sell && $item->sell->count() > 0) {
                try {
                    foreach ($item->sell as $sell) {
                        if (isset($sell->qty) && is_numeric($sell->qty)) {
                            $qty = (float)$sell->qty;
                            $qtyReturn = (isset($sell->qty_return) && is_numeric($sell->qty_return)) ? (float)$sell->qty_return : 0;
                            $item->qty_sell += ($qty - $qtyReturn);
                        }
                    }
                } catch (\Exception $e) {
                    $item->qty_sell = 0;
                }
            }
        }

        foreach ($data as $d) {
            $jumlahTotal += is_numeric($d->final_total) ? (float)$d->final_total : 0;
            $jumlahHutang += is_numeric($d->due_total) ? (float)$d->due_total : 0;
            $jumlahTerbayar += is_numeric($d->pay_total) ? (float)$d->pay_total : 0;
            $jumlahProfit += is_numeric($d->calculated_profit) ? (float)$d->calculated_profit : 0;
        }
        return view('admin.export.reports.selling',compact('data','jumlahTotal','jumlahHutang','jumlahTerbayar','status','jumlahProfit'));
    }

}
