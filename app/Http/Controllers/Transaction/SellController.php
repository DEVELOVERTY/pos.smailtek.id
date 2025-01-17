<?php

namespace App\Http\Controllers\Transaction;

use App\Exports\SellingExportDefaulth;
use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use App\Models\Admin\Store;
use App\Models\Product\Product;
use App\Models\Product\Stock;
use App\Models\Product\Variation;
use App\Models\Transaction\Purchase;
use App\Models\Transaction\Sell;
use App\Models\Transaction\SellPurchase;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class SellController extends Controller
{
    public function store(Request $request)
    {
        if (isset($request->hold) != null) {
            $validator = Validator::make($request->all(), [
                'customer_id'       => 'required',
                'hold'              => 'required',

                "qty"    => "required|array|min:0",
                "qty.*"  => "required|min:0",

                "unit_cost"    => "required|array|min:0",
                "unit_cost.*"  => "required|min:0",

                "product_id"    => "required|array|min:0",
                "product_id.*"  => "required|min:0",

                "subtotal"    => "required|array|min:0",
                "subtotal.*"  => "required|min:0",
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'errors' => $validator->errors(),
                        'message' => 'error'
                    ]);
                }
            }

            return $this->hold($request);
        } else {
            $validator = Validator::make($request->all(), [
                // 'customer_id'       => 'required',
                "qty"    => "required|array|min:0",
                "qty.*"  => "required|min:0",

                "unit_cost"    => "required|array|min:0",
                "unit_cost.*"  => "required|min:0",

                "product_id"    => "required|array|min:0",
                "product_id.*"  => "required|min:0",

                "subtotal"    => "required|array|min:0",
                "subtotal.*"  => "required|min:0",
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'errors' => $validator->errors(),
                        'message' => 'error'
                    ]);
                }
            }

            return $this->final($request);
        }
    }

    public function hold(Request $request)
    {
        if (isset($request->transaction_id)) {
            $data = Transaction::findOrFail($request->transaction_id);
        } else {
            $data = new Transaction();
        }

        $data->store_id = Session::get('mystore');
        $data->type     = 'sell';

        $data->created_by   = Auth()->user()->id;
        $data->invoice_no   = rand();
        $data->ref_no       = rand();
        $data->transaction_date = date('Y-m-d');
        $data->customer_id = $request->customer_id;
        $request->shipping ? $data->shipping_charges = $request->shipping : null;
        $request->other_price ? $data->other_charges = $request->other_price : null;
        $jumlah = 0;
        foreach ($request->subtotal as $total) {
            $jumlah += Helper::fresh_aprice($total);
        }
        $data->total_before_tax = $jumlah;
        $data->tax_amount       = $request->tax;
        if ($request->discount >= 0) {
            $data->discount_type    = 'percent';
            $data->discount_amount  = $request->discount;
        }

        $data->final_total = Helper::fresh_aprice($request->fixtotal);
        $data->status   = 'hold';
        $data->save();

        $num = count($request->qty);
        for ($x = 0; $x < $num; $x++) {
            if (isset($request->bill[$x])) {
                $sell = Sell::findOrFail($request->bill[$x]);
            } else {
                $sell = new Sell();
            }

            $sell->transaction_id = $data->id;
            $sell->store_id = Session::get('mystore');
            $getVariation = Variation::where('id', $request->variation_id[$x])->first();
            $sell->variation_id = $getVariation->id;
            $sell->product_id   = $getVariation->product_id;
            $sell->qty          = $request->qty[$x];
            $sell->qty_return   = 0;
            $sell->unit_price   = Helper::fresh_aprice($request->unit_cost[$x]);
            $sell->unit_price_before_disc = Helper::fresh_aprice($request->unit_cost[$x]);
            $sell->save();
        }

        return response()->json([
            'message' => 'hold'
        ]);
    }

    public function final(Request $request)
    {
        if (isset($request->transaction_id)) {
            $data = Transaction::findOrFail($request->transaction_id);
        } else {
            $data = new Transaction();
        }


        $store = Store::findOrFail(Session::get('mystore'));
        $kode = $store->code;

        $data->store_id = Session::get('mystore');
        $data->type     = 'sell';

        $data->created_by   = Auth()->user()->id;
        $data->invoice_no   = rand();
        $data->ref_no       = rand();
        $data->transaction_date = date('Y-m-d');
        $data->customer_id = $request->customer_id;
        $request->shipping ? $data->shipping_charges = $request->shipping : null;
        $request->other_price ? $data->other_charges = $request->other_price : null;

        $jumlah = 0;
        foreach ($request->subtotal as $total) {
            $jumlah += Helper::fresh_aprice($total);
        }
        $data->total_before_tax = $jumlah;
        $data->tax_amount       = $request->tax;
        if ($request->discount >= 0) {
            $data->discount_type    = 'percent';
            $data->discount_amount  = $request->discount;
        }


        $change = 0;
        if (Helper::fresh_aprice($request->on_pay) >= Helper::fresh_aprice($request->fixtotal) || Helper::fresh_aprice($request->on_pay) == Helper::fresh_aprice($request->fixtotal)) {
            $data->final_total =  Helper::fresh_aprice($request->fixtotal);
            $pay_back = Helper::fresh_aprice($request->on_pay) - Helper::fresh_aprice($request->fixtotal);
            $change = abs($pay_back);
            $data->status   = 'final';
            $data->payment_status = 'paid'; 
        } else {
            $data->final_total = Helper::fresh_aprice($request->fixtotal);
            $data->status   = 'due';
            $data->payment_status = 'due';
        }
        $data->save();

        $payment = new TransactionPayment();
        $payment->transaction_id = $data->id;
        if (Helper::fresh_aprice($request->on_pay) >= Helper::fresh_aprice($request->fixtotal) || Helper::fresh_aprice($request->on_pay) == Helper::fresh_aprice($request->fixtotal)) {
            $payment->amount = Helper::fresh_aprice($request->fixtotal);
        } else {
            $payment->amount = Helper::fresh_aprice($request->on_pay);
        }

        $methodpay = '';
        if ($request->no_rek) {
            $request->no_rek ? $payment->no_rek = $request->no_rek : null;
            $request->an ? $payment->an = $request->an : null;
            $request->bank_id ? $payment->bank_id = $request->bank_id : null;
            $payment->method            = 'bank_transfer';
            $methodpay = 'Debit';
        } else if ($request->card_number) {
            $request->card_number ? $payment->card_number = $request->card_number : null;
            $request->card_holder_name ? $payment->card_holder_name = $request->card_holder_name : null;
            $request->card_transaction_number ? $payment->card_transaction_number = $request->card_transaction_number : null;
            $request->card_type ? $payment->card_type = $request->card_type : null;
            $request->card_month ? $payment->card_month = $request->card_month : null;
            $request->card_year ? $payment->card_year = $request->card_year : null;
            $request->card_security ? $payment->card_security = $request->card_security : null;
            $payment->method            = 'card';
            $methodpay = 'Kartu Kredit';
        } if ($request->barcode_rfid_sidik) {
            $payment->method = 'SiDiK';
            $methodpay = 'Kartu SiDiK';
        }else {
            $payment->method            = 'cash';
            $methodpay = 'Bayar Cash';
        }

        $payment->save();
        $sell_callback = array();
        $sell_send_to_sidik_callback = array();
        $num = count($request->qty);
        for ($x = 0; $x < $num; $x++) {
            if (isset($request->bill[$x])) {
                $sell = Sell::findOrFail($request->bill[$x]);
            } else {
                $sell = new Sell();
            }
            $sell->transaction_id = $data->id;
            $sell->store_id = Session::get('mystore');
            $getVariation = Variation::where('id', $request->variation_id[$x])->first();
            $sell->variation_id = $getVariation->id;
            $sell->product_id   = $getVariation->product_id;
            $sell->qty          = $request->qty[$x];
            $sell->qty_return   = 0;
            $sell->unit_price   = Helper::fresh_aprice($request->unit_cost[$x]);
            $sell->unit_price_before_disc = Helper::fresh_aprice($request->unit_cost[$x]);
            $sell->save();

            $list_sell = array(
                'product_name'        => $sell->product->name,
                'variation_name'   => $sell->variation->name,
                'qty' => $sell->qty,
                'unit_price'  => number_format($sell->unit_price),
                'subtotal' => number_format(Helper::fresh_aprice($request->subtotal[$x]))
            );
            array_push($sell_callback, $list_sell);

            $list_sell_produk_send_to_sidik = array(
                'nama_produk' => $sell->product->name,
                'jumlah' => $sell->qty,
                'harga_jual' => $sell->unit_price,
                'subtotal' => $request->subtotal[$x]
            );
            array_push($sell_send_to_sidik_callback, $list_sell_produk_send_to_sidik);


            $sellpurchase = new SellPurchase();
            $sellpurchase->sell_id  = $sell->id;
            $sellpurchase->purchase_id  = 0;
            $getPurchase = Purchase::where('store_id', Session::get('mystore'))
                ->where('product_id', $getVariation->product_id)
                ->where('variation_id', $getVariation->id)
                ->whereRaw('quantity >= qty_sold')
                ->where("qty_sold", "!=", null)
                ->orderBy('id')
                ->first();

            $getPurchase2 = Purchase::where('store_id', Session::get('mystore'))
                ->where('product_id', $getVariation->product_id)
                ->where('variation_id', $getVariation->id)
                ->where('qty_sold', null)
                ->orderBy('id')
                ->first();

            if ($getPurchase != null) {
                $sellpurchase->purchase_id  = $getPurchase->id;
                $getPurchase->qty_sold      = $getPurchase->qty_sold + $sell->qty;
                $getPurchase->save();
            }

            if ($getPurchase2 != null) {
                $sellpurchase->purchase_id  = $getPurchase2->id;
                $getPurchase2->qty_sold      = $sell->qty;
                $getPurchase2->save();
            }

            $sellpurchase->qty          = $sell->qty;
            $sellpurchase->save();

            $stock                      = Stock::where('product_id', $sell->product_id)->where('variation_id', $sell->variation_id)->where('store_id', $data->store_id)->first();
            $stock->qty_available       = $stock->qty_available - $sell->qty;
            $stock->save();

        }

        
        if($request->barcode_rfid_sidik != null){
            $id_usercard = $request->id_usercard;

            $penjualan = [
                'id_usercard' => $id_usercard,
                'total_harga' => $data->final_total,
                'produk' => $sell_send_to_sidik_callback
            ];

            $res = Http::withHeaders([
                "Content-Type" => "application/json",
                "Accept" => "application/json, text-plain, */*",
                "X-Requested-With" => "XMLHttpRequest",
            ])
                ->post('https://admin.sidikty.com/api/transaction-paid', [
                    'penjualan' => $penjualan,
                    'token_mart' => $kode,
                ])
                ->json();
        }

        return response()->json([
            'transaction'   => $data,
            'shipping'      => number_format($request->shipping),
            'other'         => number_format($request->other_price),
            'store'         => $data->store->name,
            'address'       => $data->store->address,
            'payment'       => $request->on_pay,
            'due'           => number_format($data->due_total),
            'change'        => number_format($change),
            'paymethod'     => $methodpay,
            'subtotal'      => number_format($data->total_before_tax),
            'sell'          => $sell_callback,
            'sidik'         => $sell_send_to_sidik_callback,
            'message' => __('success')
        ]);
    }

    public function report(Request $request)
    {
        $data = Transaction::join('transaction_payments', 'transactions.id', '=', 'transaction_payments.transaction_id')
            ->where('type', 'sell')
            ->where("status", "!=", "hold")
            ->whereNull('transactions.deleted_at')
            ->orderBy('transactions.id', 'desc')
            ->paginate(20);
        $our = Transaction::join('transaction_payments', 'transactions.id', '=', 'transaction_payments.transaction_id')
            ->where('type', 'sell')
            ->where("status", "!=", "hold")
            ->whereNull('transactions.deleted_at')
            ->orderBy('transactions.id', 'desc')
            ->get();
        $user = User::all();
        $store = Store::all();
        $customer = Customer::all();
        $payment = [
            'paid'  => 'Terbayar',
            'due'   => 'Hutang',
        ];

        $status = [
            'due'   => __('general.sell_due'),
            "paid"  => __('general.paid'),
            'final' => __('general.paid')
        ];

        $jumlahTotal = 0;
        $jumlahHutang = 0;
        $jumlahTerbayar = 0;
        $jumlahProfit = 0;
        foreach ($our as $d) {
            $jumlahProfit += $d->profit;
            $jumlahTotal += $d->final_total;
            $jumlahHutang += $d->due_total;
            $jumlahTerbayar += Helper::fresh_aprice($d->pay_total);
        }
        if ($request->store != null || $request->customer != null || $request->payment != null || $request->start_date || $request->createdby != null) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->customer ?
                    $query->where('customer_id', $request->customer) : '';
            })->where(function ($query) use ($request) {
                return $request->payment ?
                    $query->where('payment_status', $request->payment) : '';
            })->where(function ($query) use ($request) {
                return $request->createdby ?
                    $query->where('created_by', $request->createdby) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where("status", "!=", "hold")->where('type', 'sell')->paginate(20);
            $our = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->customer ?
                    $query->where('customer_id', $request->customer) : '';
            })->where(function ($query) use ($request) {
                return $request->payment ?
                    $query->where('payment_status', $request->payment) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->createdby ?
                    $query->where('created_by', $request->createdby) : '';
            })->where("status", "!=", "hold")->where('type', 'sell')->get();
            $data->appends([
                'store'  => $request->store,
                'customer'  => $request->customer,
                'payment' => $request->payment,
                'status'    => $request->status,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

            $jumlahTotal = 0;
            $jumlahHutang = 0;
            $jumlahTerbayar = 0;
            $jumlahProfit = 0;
            foreach ($our as $d) {
                $jumlahTotal += $d->final_total;
                $jumlahHutang += $d->due_total;
                $jumlahTerbayar += Helper::fresh_aprice($d->pay_total);
                $jumlahProfit += $d->profit;
            }
           // dd($data);
        }

        if ($request->ajax()) {
            return view('admin.reports.transaction.sell_page', ['page' => __('sidebar.sell_report')], compact(
                'data',
                'store',
                'customer',
                'jumlahTotal',
                'jumlahHutang',
                'jumlahTerbayar',
                'payment',
                'jumlahProfit',
                'user',
                'status'
            ));
        }

        return view('admin.reports.transaction.sell', ['page' => __('sidebar.sell_report')], compact(
            'data',
            'store',
            'customer',
            'jumlahTotal',
            'jumlahHutang',
            'jumlahTerbayar',
            'payment',
            'jumlahProfit',
            'user',
            'status'
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

        return view('admin.reports.transaction.sell_detail', ['page' => __('report.sell_detail')], compact('data','status'));
    }


    public function print($id)
    {
        $data = Transaction::findOrFail($id);
        $status = [
            'due'   => __('general.sell_due'),
            "paid"  => __('general.paid'),
            'final' => __('general.paid')
        ];

        return view('admin.reports.transaction.sell_print', ['page' => __('report.sell_detail')], compact('data','status'));
    }

    public function download()
    {
        return Excel::download(new SellingExportDefaulth(), 'laporan_penjualan.xlsx');
    }
}
