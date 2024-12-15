<?php

namespace App\Http\Controllers\Transaction;

use App\Exports\ReturnExportDefaulth;
use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use App\Models\Product\Stock;
use App\Models\Product\Supplier;
use App\Models\Transaction\Purchase;
use App\Models\Transaction\ReturnDetail;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        $data = Transaction::where('type', 'purchase_return')->orderBy('id', 'desc')->paginate(20);
        $store = Store::all(); 
        if ($request->store != null || $request->start_date || $request->status) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'purchase_return')->paginate(20);
            $data->appends([
                'store'  => $request->store,   
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
        }

        if ($request->ajax()) {
            return view('admin.return.autoload_page', ['page' => __('sidebar.return')], compact('data', 'store'));
        }
        return view('admin.return.index', ['page' => __('sidebar.return')], compact('data', 'store'));
    }

    public function byPo($id)
    {
        $data = Transaction::findOrFail($id);
        return view('admin.return.po', ['page' => __('sidebar.return')], compact('data'));
    }

    public function store(Request $request)
    { 
        $validator = Validator::make($request->all(), [ 

            "qty_return"    => "required|array|min:0",
            "qty_return.*"  => "required|min:0",

            "subtotal_return"    => "required|array|min:0",
            "subtotal_return.*"  => "required|min:0",
 
            "ref_no"             => 'required',
            'amount_total'          => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = new Transaction();
        $data->store_id = Session::get('mystore');
        $data->type     = 'purchase_return';
        $data->status   = 'final';
        $data->payment_status = 'due';

        $getTransaction = Transaction::findOrFail($request->transaction_id);

        $data->supplier_id  = $getTransaction->supplier_id;
        $data->return_parent = $getTransaction->id;
        $data->created_by   = Auth()->user()->id;
        $data->invoice_no   = rand();
        $data->ref_no       = "RETURN-" . $request->ref_no;
        $data->transaction_date = date('Y-m-d');
 
        $data->total_before_tax = $request->amount_total;
        $data->final_total = $request->amount_total;
        $data->save();

        $num = count($request->subtotal_return);
        for ($x = 0; $x < $num; $x++) {
            $purchase = Purchase::findOrFail($request->p_id[$x]);
            $purchase->qty_return       = $purchase->qty_return + $request->qty_return[$x];
            $purchase->save();

            if ($getTransaction->status == 'received') {
                $CheckSkus = Stock::where('product_id', $purchase->product_id)->where('variation_id', $purchase->variation_id)->where('store_id', $purchase->store_id)->first();
                $skus = Stock::findOrFail($CheckSkus->id);
                $skus->qty_available  = $skus->qty_available -  $request->qty_return[$x];
                $skus->save();
            }

            $return = new ReturnDetail;
            $return->transaction_id = $data->id;
            $return->purchase_id = $purchase->id;
            $return->return_qty = $request->qty_return[$x];
            $return->save();
        }

        return redirect()->route('return.index')->with(['flash' => __('alert.created')]);
    }

    public function detail($id)
    {
        $return = Transaction::findOrFail($id); 
        return view('admin.return.detail', ['page' => __('purchase.detail_return')], compact( 'return'));
    }

    public function print($id)
    {
        $return = Transaction::findOrFail($id); 
        return view('admin.return.print', ['page' => __('purchase.detail_return')], compact( 'return'));
    }

    public function report(Request $request)
    {
        $data = Transaction::where('type', 'purchase_return')->orderBy('id', 'desc')->paginate(20);
        $our = Transaction::where('type', 'purchase_return')->orderBy('id', 'desc')->get();
        $store = Store::all(); 
        $jumlahTotal = 0;
        $jumlahHutang = 0; 
        foreach ($our as $d) {
            $jumlahTotal += $d->final_total;
            $jumlahHutang += $d->due_total ?? $d->final_total; 
        }
        if ($request->store != null || $request->start_date || $request->status) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'purchase_return')->paginate(20);
            $our = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'purchase_return')->get();
            $data->appends([
                'store'  => $request->store,   
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
            $jumlahTotal = 0;
        $jumlahHutang = 0; 
            foreach ($our as $d) {
                $jumlahTotal += $d->final_total;
                $jumlahHutang += $d->due_total ?? $d->final_total; 
            }
        }

        if ($request->ajax()) {
            return view('admin.reports.transaction.return_page', ['page' => __('sidebar.return_report')], compact(
                'data', 'store','jumlahTotal','jumlahHutang'
            ));
        }
        return view('admin.reports.transaction.return', ['page' => __('sidebar.return_report')], compact(
            'data', 'store','jumlahTotal','jumlahHutang'
        ));
    }

    public function download()
    {
        return Excel::download(new ReturnExportDefaulth(),'laporan_purchase_return.xlsx');
    }
}
