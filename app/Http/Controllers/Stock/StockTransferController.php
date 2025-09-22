<?php

namespace App\Http\Controllers\Stock;

use App\Exports\TransferDefaulth;
use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use App\Models\Product\Product;
use App\Models\Product\Stock;
use App\Models\Stock\StockTransferDetail;
use App\Models\Transaction\Purchase;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel; 

class StockTransferController extends Controller
{

    public function index(Request $request)
    {
        $data = Transaction::where('type', 'stock_transfer')->orderBy('id', 'desc')->paginate(20);
        $store = Store::all();

        $status = [
            'transit'   => __('transfer.transit'),
            'complete'  => __('transfer.complete'),
            'pending'   => __('transfer.pending')
        ];

        if ($request->start_date || $request->status) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'stock_transfer')->paginate(20);
            $data->appends([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
        }

        if ($request->ajax()) {
            return view('admin.stock_transfer.autoload_page', ['page' => __('sidebar.stock_transfer')], compact('data', 'store','status'));
        }
        return view('admin.stock_transfer.index', ['page' => __('sidebar.stock_transfer')], compact('data', 'store','status'));
    }

    public function create()
    { 
        $status = [
            'pending'   => 'Pending',
            'transit'   => 'In Transit',
            'complete'  => 'Completed'
        ];
        $store = Store::all();
        return view('admin.stock_transfer.create', ['page' => __('sidebar.add_stock_transfer')], compact('status', 'store'));
    }

    public function getStore($id)
    {
        $data   = '<option value=""> Pilih Toko</option>';
        $getData = Store::where('id', '!=', $id)->get();
        foreach ($getData as $c) {
            $data .= '<option value=" ' . $c->id . '"> ' . $c->name . '</option>';
        }
        echo $data;
    }

    public function changeStatus(Request $request)
    {
        $this->validate($request, [
            'status'        => 'required'
        ]);

        $data = Transaction::findOrFail($request->id);

        foreach ($data->manytransfer as $d) {
            $getTo = Stock::where('product_id', $d->stock->product_id)
                ->where('variation_id', $d->stock->variation_id)
                ->where('store_id', $d->to)
                ->first();
            $getFrom = Stock::where('product_id', $d->stock->product_id)
                ->where('variation_id', $d->stock->variation_id)
                ->where('store_id', $d->from)
                ->first();

            // Pending Status To Transit Status
            if ($data->status == 'pending' && $request->status == 'transit') {
                if ($getFrom->qty_available <= 0) {
                    return redirect()->route('transfer.index')->with(['gagal' => __('alert.stock_habis')]);
                }
                $getFrom->qty_available = $getFrom->qty_available - $d->transfer_qty;
                $getFrom->save();
            }

            // Pending Status To Complete Status
            if ($data->status == 'pending' && $request->status == 'complete') {
                if ($getFrom->qty_available <= 0) {
                    return redirect()->route('transfer.index')->with(['gagal' => __("alert.stock_habis")]);
                }
                $getFrom->qty_available = $getFrom->qty_available - $d->transfer_qty;
                $getFrom->save();

                if ($getTo == null) {
                    $to = new Stock();
                    $to->qty_available  = $d->transfer_qty;
                    $to->product_id     = $d->stock->product_id;
                    $to->variation_id   = $d->stock->variation_id;
                    $to->store_id       = $d->to;
                    $to->save();
                } else {
                    $to = Stock::findOrFail($getTo->id);
                    $to->qty_available = $to->qty_available + $d->transfer_qty;
                    $to->save();
                }
            }

            // Transit Status To Complete Status
            if ($data->status == 'transit' && $request->status == 'complete') {

                if ($getTo == null) {
                    $to = new Stock();
                    $to->qty_available  = $d->transfer_qty;
                    $to->product_id     = $d->stock->product_id;
                    $to->variation_id   = $d->stock->variation_id;
                    $to->store_id       = $d->to;
                    $to->save();
                } else {
                    $to = Stock::findOrFail($getTo->id);
                    $to->qty_available = $to->qty_available + $d->transfer_qty;
                    $to->save();
                }
            }
        }
        $data->status = $request->status;
        return $this->saveData($data);
    }

    public function getProduct(Request $request)
    {
        $response = array();
        if ($request->store != null) {
            if ($request->term != null) {
                $getdata = Product::where('name', 'like', '%' . $request->term . '%')->limit(20)->get();
                foreach ($getdata as $product) {
                    foreach ($product->variant as $v) {
                        $getStock = Stock::where('variation_id', $v->id)->where('store_id', $request->store)->first();
                        if ($getStock != null) {
                            if ($product->type == 'single') {
                                $name = '';
                            } else {
                                $name = $v->name;
                            }
                            $response[] = [
                                'id'    => $v->id,
                                'name'  => $product->name . ' - ' . $name
                            ];
                        }
                    }
                }
                return response()->json($response);
            } else {
                $getdata = Product::limit(20)->get();
                foreach ($getdata as $product) {
                    foreach ($product->variant as $v) {
                        $getStock = Stock::where('variation_id', $v->id)->where('store_id', $request->store)->first();
                        if ($getStock != null) {
                            if ($product->type == 'single') {
                                $name = '';
                            } else {
                                $name = $v->name;
                            }
                            $response[] = [
                                'id'    => $v->id,
                                'name'  => $product->name . ' - ' . $name
                            ];
                        }
                    }
                }
            }
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from'        => 'required',
            'to'            => 'required',
            'status'             => 'required',

            "qty"    => "required|array|min:0",
            "qty.*"  => "required|min:0",

            "unit_cost"    => "required|array|min:0",
            "unit_cost.*"  => "required|min:0",

            "ref_no"             => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new Transaction();
        $data->store_id = Session::get('mystore');
        $data->type     = 'stock_transfer';
        $data->status   = $request->status;
        $data->payment_status = 'paid';

        $data->created_by   = Auth()->user()->id;
        $data->invoice_no   = rand();
        $data->ref_no       = "TF-" . str_replace(' ','',$request->ref_no);
        $data->transaction_date = date('Y-m-d');

        $data->total_before_tax = $request->amount_total;
        $data->tax_amount       = 0;

        $request->shipping_details ? $data->shipping_details = $request->shipping_details : null;
        $request->shipping_charges ? $data->shipping_charges = Helper::fresh_aprice($request->shipping_charges) : null;
        $request->additional_note ? $data->additional_notes = $request->additional_note : null;
        $data->final_total = $request->net_total;
        $data->save();

        $num = count($request->line_total);
        for ($x = 0; $x < $num; $x++) {

            $getFrom = Stock::where('product_id', $request->product_id[$x])
                ->where('variation_id', $request->variant_id[$x])
                ->where('store_id', $request->from)
                ->first();

            $getTo = Stock::where('product_id', $request->product_id[$x])
                ->where('variation_id', $request->variant_id[$x])
                ->where('store_id', $request->to)
                ->first();

            if($request->status == 'transit') {
                $getFrom->qty_available = $getFrom->qty_available - $request->qty[$x];
                $getFrom->save();
            }

            if ($request->status == 'complete') {
                $getFrom->qty_available = $getFrom->qty_available - $request->qty[$x];
                $getFrom->save();

                if ($getTo == null) {
                    $to = new Stock();
                    $to->qty_available          = $request->qty[$x];
                    $to->product_id     = $request->product_id[$x];
                    $to->variation_id   = $request->variant_id[$x];
                    $to->store_id       = $request->to;
                    $to->save();
                } else {
                    $to = Stock::findOrFail($getTo->id);
                    $to->qty_available = $to->qty_available + $request->qty[$x];
                    $to->save();
                }
            }
            $transfer = new StockTransferDetail();
            $transfer->transaction_id   = $data->id;
            $transfer->from             = $request->from;
            $transfer->to               = $request->to;
            $transfer->stock_id         = $getFrom->id;
            $transfer->transfer_qty     = $request->qty[$x];
            $transfer->save();
        }
        return redirect()->route('transfer.index')->with(['flash' => __('alert.created')]);
    }

    public function detail($id)
    {
        $transfer = Transaction::findOrFail($id);
        return view('admin.stock_transfer.detail', ['page' => __('sidebar.stock_transfer')], compact('transfer'));
    }

    public function print($id)
    {
        $transfer = Transaction::findOrFail($id);
        return view('admin.stock_transfer.print', ['page' => __('sidebar.stock_transfer')], compact('transfer'));
    }

    public function report(Request $request)
    {
        $data = Transaction::where('type', 'stock_transfer')->orderBy('id', 'desc')->paginate(20);
        $store = Store::all();
        $status = [
            'transit'   => __('transfer.transit'),
            'complete'  => __('transfer.complete'),
            'pending'   => __('transfer.pending')
        ];
        $jumlah = 0;
        foreach ($data as $d) {
            $jumlah += $d->final_total;
        }
        if ($request->start_date || $request->status) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'stock_transfer')->paginate(20);
            $data->appends([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
            $jumlah = 0;
            foreach ($data as $d) {
                $jumlah += $d->final_total;
            }
        }

        if ($request->ajax()) {
            return view('admin.reports.stock.transfer_page', ['page' => __('sidebar.r_stock_transfer')], compact('data', 'store', 'jumlah','status'));
        }
        return view('admin.reports.stock.transfer', ['page' => __('sidebar.r_stock_transfer')], compact('data', 'store', 'jumlah','status'));
    }

    public function download()
    {
        return Excel::download(new TransferDefaulth(), 'stock_transfer.xlsx');
    }
}
