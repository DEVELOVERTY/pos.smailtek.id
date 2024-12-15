<?php

namespace App\Http\Controllers\Transaction;

use App\Exports\DueBookDefaulth;
use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use App\Models\Admin\Store;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionPayment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DueController extends Controller
{
    public function index(Request $request)
    {
        $data = Transaction::where('type', 'sell')->where('payment_status', 'due')->where('status', 'due')->orderBy('id', 'desc')->paginate(20);
        $our =  Transaction::where('type', 'sell')->where('payment_status', 'due')->where('status', 'due')->orderBy('id', 'desc')->get();
        $store = Store::all();
        $customer = Customer::all();

        $jumlahTotal = 0;
        $jumlahHutang = 0;
        $jumlahTerbayar = 0;
        foreach ($our as $d) {
            $jumlahTotal += $d->final_total;
            $jumlahHutang += $d->due_total;
            $jumlahTerbayar += Helper::fresh_aprice($d->pay_total);
        }
        if ($request->store != null || $request->customer != null || $request->payment != null || $request->start_date) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->customer ?
                    $query->where('customer_id', $request->customer) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'sell')->where('status', 'due')->where('payment_status', 'due')->paginate(20);
            $our = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->customer ?
                    $query->where('customer_id', $request->customer) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'sell')->where('status', 'due')->where('payment_status', 'due')->get();
            $data->appends([
                'store'  => $request->store,
                'customer'  => $request->customer,
                'status'    => $request->status,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

            $jumlahTotal = 0;
            $jumlahHutang = 0;
            $jumlahTerbayar = 0;
            foreach ($our as $d) {
                $jumlahTotal += $d->final_total;
                $jumlahHutang += $d->due_total;
                $jumlahTerbayar += Helper::fresh_aprice($d->pay_total);
            }
        }

        if ($request->ajax()) {
            return view('admin.reports.transaction.due_page', ['page' => __('sidebar.debt_book')], compact(
                'data',
                'store',
                'customer',
                'jumlahTotal',
                'jumlahHutang',
                'jumlahTerbayar'
            ));
        }
        return view('admin.reports.transaction.due', ['page' => __('sidebar.debt_book')], compact(
            'data',
            'store',
            'customer',
            'jumlahTotal',
            'jumlahHutang',
            'jumlahTerbayar'
        ));
    }

    public function detail($id)
    {
        $data = Transaction::findOrFail($id);
        $status = [
            'due'   => __('general.sell_due'),
            "paid"  => __('general.paid'),
            'final' => __('general.paid')
        ];
        return view('admin.reports.transaction.due_detail', ['page' => __('report.due_detail')], compact('data','status'));
    }

    public function listPembayaran($id, Request $request)
    {
        $data       = Transaction::findOrFail($id);
        $payment    = TransactionPayment::where('transaction_id', $data->id)->orderBy('id', 'desc')->get();

        if ($request->start_date) {
            $payment = TransactionPayment::where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('transaction_id', $data->id)->orderBy('id', 'desc')->get(); 
        }

        if ($request->ajax()) {
            return view('admin.reports.transaction.due_payment_page', ['page' => __('report.due_detail')], compact('data','payment'));
        }
        return view('admin.reports.transaction.due_payment', ['page' => __('report.due_detail')], compact('data','payment'));
    }

    public function print($id)
    {
        $data = Transaction::findOrFail($id);
        $status = [
            'due'   => __('general.sell_due'),
            "paid"  => __('general.paid'),
            'final' => __('general.paid')
        ];
        return view('admin.reports.transaction.due_print', ['page' => __('general.print')], compact('data','status'));
    }

    public function download()
    {
        return Excel::download(new DueBookDefaulth(),'buku_hutang.xlsx');
    }
}
