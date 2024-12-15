<?php

namespace App\Http\Controllers\Transaction;

use App\Exports\ReturnSellExport;
use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use App\Models\Product\Stock;
use App\Models\Transaction\Purchase;
use App\Models\Transaction\SalesReturn;
use App\Models\Transaction\Sell;
use App\Models\Transaction\SellPurchase;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SalesReturnController extends Controller
{

    public function index(Request $request)
    {
        $data = Transaction::where('type', 'sales_return')->orderBy('id', 'desc')->paginate(20);
        $our = Transaction::where('type', 'sales_return')->orderBy('id', 'desc')->get();
        $store = Store::all(); 
        
        if ($request->store != null || $request->start_date || $request->status) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'sales_return')->paginate(20);
            $our = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where('type', 'sales_return')->get();
            $data->appends([
                'store'  => $request->store,   
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
             
        }

        if ($request->ajax()) {
            return view('admin.returnsell.load_page', ['page' => __('sell.return_sell')], compact(
                'data', 'store'
            ));
        }
        return view('admin.returnsell.index', ['page' => __('sell.return_sell')], compact(
            'data', 'store'
        ));
    }

    public function bysell($id)
    {
        $data = Transaction::where("type", 'sell')->where("id", $id)->first();
        return view('admin.returnsell.create', ['page' => __('sidebar.sell_return')], compact('data'));
    }

    public function getProduct($id)
    {
        $parent = Transaction::findOrFail($id);
        $data['sales']  = array();
        foreach ($parent->sell as $sell) {
            $available_stock = $sell->qty - $sell->qty_return;
            if($available_stock != 0) {
                $name = $sell->product->name ?? '';
                $variation = $sell->variation->name ?? '';
                
                $list = [
                    'id'    => $sell->id,
                    'name'  => $name . ' ' . $variation . ' (' . $available_stock . ')',
                    'stock' => $available_stock
                ];
                array_push($data['sales'], $list);
            }
         
        }
        return response()->json($data['sales']);
    }

    public function domItem($id)
    {
        $data = Sell::findOrFail($id); 
        $name = $data->product->name ?? '';
        $variation = $data->variation->name ?? '';
        $available_stock = $data->qty - $data->qty_return;
        return response()->json([
            'product' => [
                'name'      => $name .' '. $variation,
                'sell_id'   => $data->id, 
                'product_id'=> $data->product->id,
                'var_id'    => $data->variation->id,
                's_price'   => number_format($data->unit_price),
                'price'     => $data->unit_price,
                'stock'     => $available_stock,
            ]
        ]);
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
        $data->type     = 'sales_return';
        $data->status   = 'final';
        $data->payment_status = 'paid';

        $getTransaction = Transaction::findOrFail($request->transaction_id);

        $data->return_parent = $getTransaction->id;
        $data->created_by   = Auth()->user()->id;
        $data->invoice_no   = rand();
        $data->ref_no       = "RETURNSELL-" . $request->ref_no;
        $data->transaction_date = date('Y-m-d');
        $data->customer_id  = $getTransaction->customer_id;
        $data->total_before_tax = $request->amount_total;
        $data->final_total = $request->amount_total;
        $data->save();

        $num = count($request->subtotal_return);
        for ($x = 0; $x < $num; $x++) {
            $sell = Sell::findOrFail($request->sell_id[$x]);
            $sell->qty_return       = $sell->qty_return + $request->qty_return[$x];
            $sell->save();

            $sellpurchase = SellPurchase::where("sell_id",$request->sell_id[$x])->first();
            $sellpurchase->qty_return = $sellpurchase->qty_return + $request->qty_return[$x];
            $sellpurchase->save();

            if($request->condition[$x] == 'good') {
                $purchase = Purchase::where("id",$sellpurchase->purchase_id)->first();
                $purchase->qty_sold = $purchase->qty_sold - $request->qty_return[$x];
                $purchase->save();

                $stock = Stock::where("product_id",$request->product_id[$x])->where("variation_id",$request->variation_id[$x])->where("store_id",Session::get('mystore'))->first();
                $stock->qty_available = $stock->qty_available + $request->qty_return[$x];
                $stock->save();
            }

            

            $return = new SalesReturn();
            $return->transaction_id = $data->id;
            $return->sell_id = $sell->id;
            $return->return_qty = $request->qty_return[$x];
            $return->condition = $request->condition[$x];
            $return->save();
        }

        return redirect()->route('returnsell.index')->with(['flash' => __('alert.created')]);
    }

    public function download()
    {
        return Excel::download(new ReturnSellExport(),'report_returnsell.xlsx');
    }

    public function detail($id)
    {
        $return = Transaction::findOrFail($id); 
        $condition = [
            'good'  => __('sell.good'),
            'broken'=> __('sell.broken')
        ];
        return view('admin.returnsell.detail', ['page' => __('purchase.detail_return')], compact( 'return','condition'));
    }

    public function print($id)
    {
        $return = Transaction::findOrFail($id);
        $condition = [
            'good'  => __('sell.good'),
            'broken'=> __('sell.broken')
        ]; 
        return view('admin.returnsell.print', ['page' => __('purchase.detail_return')], compact( 'return','condition'));
    }
}
