<?php

namespace App\Http\Controllers\Stock;

use App\Exports\AdjustmentDefaulth;
use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use App\Models\Product\Stock;
use App\Models\Stock\StockAdjusmentDetail;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class StockAdjustmentController extends Controller
{
    public function index(Request $request)
    {
        $data = Transaction::where('type', 'stock_adjustment')->orderBy('id', 'desc')->paginate(20); 
        if ($request->start_date) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'stock_adjustment')->paginate(20);
            $data->appends([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
        }

        if ($request->ajax()) {
            return view('admin.adjustment.autoload_page', ['page' => __('sidebar.stock_adjs')], compact('data'));
        }
        return view('admin.adjustment.index', ['page' => __('sidebar.stock_adjs')], compact('data'));
    }

    public function create()
    {
        $type = [
            'normal'        => 'Normal',
            'abnormal'      => 'Abnormal'
        ];
        return view('admin.adjustment.create',['page' => __('sidebar.create_adjs')],compact('type'));
    }

    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [ 
            'type'            => 'required',  
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
        $data->type     = 'stock_adjustment';  

        $data->created_by   = Auth()->user()->id;
        $data->invoice_no   = rand();
        $data->ref_no       = "ADJUSTMENT-" . $request->ref_no;
        $data->transaction_date = date('Y-m-d');
        $data->adjustment_type = $request->type;

        $data->total_before_tax = 0;
        $data->tax_amount       = 0;
 
        $request->total_amount_recovered ? $data->total_amount_recovered = Helper::fresh_aprice($request->total_amount_recovered) : null;
        $request->additional_note ? $data->additional_notes = $request->additional_note : null;
        $data->final_total = $request->amount_total;
        $data->save();

        $num = count($request->line_total);
        for ($x = 0; $x < $num; $x++) {

            $getFrom = Stock::where('product_id', $request->product_id[$x])
                ->where('variation_id', $request->variant_id[$x])
                ->where('store_id', Session::get('mystore'))
                ->first();
            $getFrom->qty_available = $getFrom->qty_available - $request->qty[$x];
            $getFrom->save();
           
            $transfer = new StockAdjusmentDetail();
            $transfer->transaction_id   = $data->id;
            $transfer->store_id = Session::get('mystore');
            $transfer->product_id       = $request->product_id[$x];
            $transfer->variation_id     = $request->variant_id[$x];
            $transfer->qty_adjustment   = $request->qty[$x];
            $transfer->unit_price       = Helper::fresh_aprice($request->unit_cost[$x]);
            $transfer->save();
        }
        return redirect()->route('adjustment.index')->with(['flash' => __('alert.created')]);
    }

    public function detail($id)
    {
        $adjustment = Transaction::findOrFail($id);
        return view('admin.adjustment.detail',['page' => __('adjustment.detail')],compact('adjustment'));
    }

    public function print($id)
    {
        $adjustment = Transaction::findOrFail($id);
        return view('admin.adjustment.print',['page' => __('adjustment.detail')],compact('adjustment'));
    }

    public function report(Request $request)
    {
        $data = Transaction::where('type', 'stock_adjustment')->orderBy('id', 'desc')->paginate(20); 

        $jumlah = 0;
        foreach($data as $d) {
            $jumlah += $d->total_amount_recovered;
        }
        $store = Store::all();
        if ($request->start_date || $request->store) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where('type', 'stock_adjustment')->paginate(20);
            $data->appends([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

            $jumlah = 0;
            foreach($data as $d) {
                $jumlah += $d->total_amount_recovered;
            }
        }

        if ($request->ajax()) {
            return view('admin.reports.stock.adjustment_page', ['page' => __('sidebar.stock_adjs')], compact('data','store','jumlah'));
        }
        return view('admin.reports.stock.adjustment', ['page' => __('sidebar.stock_adjs')], compact('data','store','jumlah'));
    }

    public function download()
    {
        return Excel::download(new AdjustmentDefaulth(),'stock_adjustment.xlsx');
    }
    
}
