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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\StoreToken;

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
        // Debug logging
        Log::info('Starting transaction process', [
            'is_sidik' => $request->barcode_rfid_sidik != null,
            'transaction_id' => $request->transaction_id ?? 'new',
            'total' => $request->fixtotal ?? 'unknown'
        ]);

        // Start database transaction for atomicity
        return DB::transaction(function () use ($request) {
            try {
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

                // For SiDiK transactions, validate with Kedit BEFORE saving local transaction
                if($request->barcode_rfid_sidik != null){
                    Log::info('Processing SiDiK transaction validation');
                    $sidikValidation = $this->validateSidikTransaction($request, $data);
                    if (!$sidikValidation['success']) {
                        Log::error('SiDiK validation failed', ['error' => $sidikValidation['message']]);
                        throw new \Exception($sidikValidation['message']);
                    }
                    Log::info('SiDiK validation passed successfully');
                }

                // Save transaction only after SiDiK validation passes
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
                } else if ($request->barcode_rfid_sidik) {
                    $payment->method = 'sidik';
                    $methodpay = 'Kartu SiDiK';
                } else {
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
                        'subtotal' => str_replace(',', '', $request->subtotal[$x])
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

                    $stock = Stock::where('product_id', $sell->product_id)->where('variation_id', $sell->variation_id)->where('store_id', $data->store_id)->first();
                    if ($stock) {
                        $stock->qty_available = $stock->qty_available - $sell->qty;
                        $stock->save();
                    } else {
                        Log::warning('Stock not found for product', [
                            'product_id' => $sell->product_id,
                            'variation_id' => $sell->variation_id,
                            'store_id' => $data->store_id
                        ]);
                    }
                }

                // Log successful transaction
                Log::info('Transaction completed successfully', [
                    'transaction_id' => $data->id,
                    'ref_no' => $data->ref_no,
                    'final_total' => $data->final_total,
                    'payment_method' => $methodpay,
                    'is_sidik' => $request->barcode_rfid_sidik != null
                ]);

                return response()->json([
                    'transaction'   => $data,
                    'shipping'      => number_format($request->shipping ?? 0),
                    'other'         => number_format($request->other_price ?? 0),
                    'store'         => $data->store->name ?? '',
                    'address'       => $data->store->address ?? '',
                    'payment'       => $request->on_pay ?? 0,
                    'due'           => number_format($data->due_total ?? 0),
                    'change'        => number_format($change),
                    'paymethod'     => $methodpay,
                    'subtotal'      => number_format($data->total_before_tax),
                    'sell'          => $sell_callback,
                    'message' => __('success')
                ]);

            } catch (\Exception $e) {
                Log::error('Transaction failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'error' => 'Transaction failed: ' . $e->getMessage(),
                    'message' => 'error'
                ], 500);
            }
        });
    }

    public function report(Request $request)
    {
        // --- Query dasar yang lebih sederhana ---
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

        // --- Filter ---
        if ($request->store) $query->where('transactions.store_id', $request->store);
        if ($request->customer) $query->where('transactions.customer_id', $request->customer);
        if ($request->payment) $query->where('transactions.payment_status', $request->payment);
        if ($request->createdby) $query->where('transactions.created_by', $request->createdby);
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('transactions.created_at', [$request->start_date, $request->end_date]);
        }
        
        // Filter berdasarkan metode pembayaran
        if ($request->payment_method) {
            $query->whereHas('payment', function($q) use ($request) {
                $q->where('method', $request->payment_method);
            });
        }

        // --- Pagination dengan eager loading ---
        $data = (clone $query)->with([
            'store:id,name',
            'customer:id,name', 
            'createdby:id,name'
        ])->paginate(20);

        // --- Hitung summary dari data yang sudah dipaginate ---
        $allData = (clone $query)->get();
        
        // Pastikan semua nilai numeric dengan validasi
        $jumlahTotal = 0;
        $jumlahTerbayar = 0;
        $jumlahHutang = 0;
        $jumlahProfit = 0;
        
        foreach ($allData as $transaction) {
            $jumlahTotal += $this->safeNumeric($transaction->final_total);
            $jumlahTerbayar += $this->safeNumeric($transaction->pay_total);
            $jumlahHutang += $this->safeNumeric($transaction->due_total);
        }
        
        // Hitung profit secara batch untuk efisiensi
        $allTransactionIds = $allData->pluck('id')->toArray();
        if (!empty($allTransactionIds)) {
            $profitData = $this->calculateProfitBatch($allTransactionIds);
            $jumlahProfit = array_sum($profitData);
        }

        // --- Optimasi: Hitung jumlah sell items dalam batch ---
        $transactionIds = $data->pluck('id')->toArray();
        if (!empty($transactionIds)) {
            $sellCounts = DB::table('sells')
                ->select('transaction_id', DB::raw('COUNT(*) as sell_count'))
                ->whereIn('transaction_id', $transactionIds)
                ->groupBy('transaction_id')
                ->pluck('sell_count', 'transaction_id');

            $qtySells = DB::table('sells')
                ->select('transaction_id', DB::raw('SUM(qty - COALESCE(qty_return, 0)) as total_qty'))
                ->whereIn('transaction_id', $transactionIds)
                ->groupBy('transaction_id')
                ->pluck('total_qty', 'transaction_id');

            // Hitung profit untuk pagination items
            $paginationProfits = $this->calculateProfitBatch($transactionIds);
            
            // Attach data ke setiap item dengan validasi numeric
            $data->getCollection()->transform(function ($item) use ($sellCounts, $qtySells, $paginationProfits) {
                $item->sell_count = (int)($sellCounts[$item->id] ?? 0);
                $item->qty_sell = (int)($qtySells[$item->id] ?? 0);
                
                // Pastikan semua nilai numeric menggunakan helper
                $item->final_total = $this->safeNumeric($item->final_total);
                $item->pay_total = $this->safeNumeric($item->pay_total);
                $item->due_total = $this->safeNumeric($item->due_total);
                
                // Gunakan profit dari batch calculation
                $item->profit = $this->safeNumeric($paginationProfits[$item->id] ?? 0);
                
                return $item;
            });
        }

        // --- Cache data yang jarang berubah ---
        try {
            $user = cache()->remember('users_for_report', 300, function() {
                return User::select('id', 'name')->get();
            });
            
            $store = cache()->remember('stores_for_report', 300, function() {
                return Store::select('id', 'name')->get();
            });
            
            $customer = cache()->remember('customers_for_report', 300, function() {
                return Customer::select('id', 'name')->get();
            });
        } catch (\Exception $e) {
            $user = User::select('id', 'name')->get();
            $store = Store::select('id', 'name')->get();
            $customer = Customer::select('id', 'name')->get();
        }

        $payment = [
            'paid'  => 'Terbayar',
            'due'   => 'Hutang',
        ];

        // Data metode pembayaran untuk filter sesuai sistem SiDiK
        $payment_methods = [
            'cash' => 'Tunai (Cash)',
            'sidik' => 'Kartu SiDiK',
            'bank_transfer' => 'Transfer Bank',
            'card' => 'Kartu Kredit/Debit',
            'other' => 'Lainnya'
        ];

        $status = [
            'due'   => __('general.sell_due'),
            'paid'  => __('general.paid'),
            'final' => __('general.paid')
        ];

        // --- Appends pagination ---
        $data->appends($request->only('store','customer','payment','createdby','start_date','end_date','payment_method'));

        // --- Return view ---
        $viewData = compact(
            'data', 'store', 'customer', 'payment', 'payment_methods', 'user', 'status',
            'jumlahTotal', 'jumlahTerbayar', 'jumlahHutang', 'jumlahProfit'
        );

        if ($request->ajax()) {
            return view('admin.reports.transaction.sell_page', ['page' => __('sidebar.sell_report')], $viewData);
        }

        return view('admin.reports.transaction.sell', ['page' => __('sidebar.sell_report')], $viewData);
    }

    private function calculateProfit($transactionId)
    {
        try {
            $result = DB::table("transactions as t")
                ->join('sells as s', 't.id', '=', 's.transaction_id')
                ->leftJoin('sell_purchases as sp', 's.id', '=', 'sp.sell_id')
                ->leftJoin('purchases as pp', 'sp.purchase_id', '=', 'pp.id')
                ->selectRaw("
                    COALESCE(SUM(
                        (COALESCE(s.qty, 0) - COALESCE(s.qty_return, 0)) * 
                        (COALESCE(s.unit_price_before_disc, 0) - COALESCE(pp.purchase_price, 0))
                    ), 0) AS profit
                ")
                ->where("t.id", $transactionId)
                ->first();
            
            return $this->safeNumeric($result->profit ?? 0);
        } catch (\Exception $e) {
            Log::error("Error calculating profit for transaction {$transactionId}: " . $e->getMessage());
            return 0;
        }
    }

    private function calculateProfitBatch($transactionIds)
    {
        try {
            if (empty($transactionIds)) {
                return [];
            }

            $results = DB::table("transactions as t")
                ->join('sells as s', 't.id', '=', 's.transaction_id')
                ->leftJoin('sell_purchases as sp', 's.id', '=', 'sp.sell_id')
                ->leftJoin('purchases as pp', 'sp.purchase_id', '=', 'pp.id')
                ->selectRaw("
                    t.id as transaction_id,
                    COALESCE(SUM(
                        (COALESCE(s.qty, 0) - COALESCE(s.qty_return, 0)) * 
                        (COALESCE(s.unit_price_before_disc, 0) - COALESCE(pp.purchase_price, 0))
                    ), 0) AS profit
                ")
                ->whereIn("t.id", $transactionIds)
                ->groupBy('t.id')
                ->get();

            $profitData = [];
            foreach ($results as $result) {
                $profitData[$result->transaction_id] = $this->safeNumeric($result->profit);
            }

            // Pastikan semua transaction_id ada dalam array dengan default 0
            foreach ($transactionIds as $id) {
                if (!isset($profitData[$id])) {
                    $profitData[$id] = 0;
                }
            }

            return $profitData;
        } catch (\Exception $e) {
            Log::error("Error calculating profit batch: " . $e->getMessage());
            return array_fill_keys($transactionIds, 0);
        }
    }

    private function safeNumeric($value, $default = 0)
    {
        if (is_null($value) || $value === '' || $value === false) {
            return $default;
        }
        
        if (is_numeric($value)) {
            return (float) $value;
        }
        
        // Coba bersihkan string yang mungkin mengandung karakter non-numeric
        $cleaned = preg_replace('/[^0-9.-]/', '', $value);
        if (is_numeric($cleaned)) {
            return (float) $cleaned;
        }
        
        return $default;
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

    public function download(Request $request)
    {
        // Kirim parameter filter ke export class
        $filters = $request->only('store','customer','payment','createdby','start_date','end_date','payment_method');
        return Excel::download(new SellingExportDefaulth($filters), 'laporan_penjualan.xlsx');
    }

    /**
     * Validate SiDiK transaction before saving local transaction
     */
    private function validateSidikTransaction(Request $request, Transaction $transaction)
    {
        try {
            $id_usercard = $request->id_usercard;
            
            // Get store token for Kedit API
            $storeToken = $this->getCurrentStoreToken();
            
            if (!$storeToken) {
                Log::error('Store token not found for SiDiK validation', [
                    'store_id' => Session::get('mystore')
                ]);
                return [
                    'success' => false,
                    'message' => 'Store token not configured. Cannot process SIDIK payment.'
                ];
            }

            // Verify fingerprint was validated before processing payment
            $transactionCode = $request->transaction_code ?? null;
            if ($transactionCode) {
                $fingerprintVerified = \App\Models\LogFinger::where('transaction_code', $transactionCode)
                    ->where('finger', 'true')
                    ->exists();
                
                if (!$fingerprintVerified) {
                    Log::error('Fingerprint not verified for SiDiK transaction', [
                        'transaction_code' => $transactionCode
                    ]);
                    return [
                        'success' => false,
                        'message' => 'Fingerprint verification required for SIDIK payment.'
                    ];
                }
            }

            // Prepare product data for SiDiK
            $sell_send_to_sidik_callback = [];
            $num = count($request->qty);
            for ($x = 0; $x < $num; $x++) {
                $getVariation = Variation::where('id', $request->variation_id[$x])->first();
                $product = $getVariation->product;
                
                $list_sell_produk_send_to_sidik = [
                    'nama_produk' => $product->name,
                    'jumlah' => $request->qty[$x],
                    'harga_jual' => Helper::fresh_aprice($request->unit_cost[$x]),
                    'subtotal' => str_replace(',', '', $request->subtotal[$x])
                ];
                array_push($sell_send_to_sidik_callback, $list_sell_produk_send_to_sidik);
            }

            $penjualan = [
                'id_usercard' => $id_usercard,
                'total_harga' => $transaction->final_total,
                'produk' => $sell_send_to_sidik_callback,
                'carabayar' => 'Kartu SiDiK',
                'transaction_code' => $transactionCode,
                'store_id' => Session::get('mystore'),
                'ref_no' => $transaction->ref_no ?? 'TEMP_' . time()
            ];

            $keditBaseUrl = config('kedit.base_url');
            Log::info('Validating SiDiK transaction', [
                'url' => $keditBaseUrl . '/api/transaction-paid',
                'penjualan' => $penjualan,
                'token_mart' => $storeToken
            ]);

            $res = Http::withHeaders([
                "Content-Type" => "application/json",
                "Accept" => "application/json, text-plain, */*",
                "X-Requested-With" => "XMLHttpRequest",
            ])
            ->timeout(30) // Increased timeout for critical validation
            ->post($keditBaseUrl . '/api/transaction-paid', [
                'penjualan' => $penjualan,
                'token_mart' => $storeToken,
            ])
            ->json();

            Log::info('SiDiK validation response', [
                'response' => $res,
                'response_type' => gettype($res),
                'response_keys' => is_array($res) ? array_keys($res) : 'not_array'
            ]);

            // Validate response more flexibly
            if (!$res) {
                Log::error('No response from SiDiK system');
                return [
                    'success' => false,
                    'message' => 'No response from SiDiK system. Transaction cannot be processed.'
                ];
            }

            // Check for explicit error status
            if (isset($res['status']) && $res['status'] === 'error') {
                Log::error('SiDiK returned error status', ['response' => $res]);
                return [
                    'success' => false,
                    'message' => 'SiDiK transaction failed: ' . ($res['message'] ?? 'Unknown error')
                ];
            }

            // Check if balance deduction was successful (only if field exists)
            if (isset($res['saldo_terpotong']) && $res['saldo_terpotong'] === false) {
                Log::error('SiDiK balance deduction failed', ['response' => $res]);
                return [
                    'success' => false,
                    'message' => 'Insufficient balance in SiDiK card or balance deduction failed.'
                ];
            }

            // More flexible success validation - accept if no explicit error
            $isSuccess = true;
            if (isset($res['success'])) {
                $isSuccess = $res['success'] === true || $res['success'] === 'true' || $res['success'] === 1;
            }
            
            if (!$isSuccess && isset($res['status']) && $res['status'] !== 'success') {
                Log::warning('SiDiK transaction may have failed', ['response' => $res]);
                return [
                    'success' => false,
                    'message' => 'SiDiK transaction validation failed: ' . ($res['message'] ?? 'Please check response')
                ];
            }

            Log::info('SiDiK transaction validated successfully', [
                'transaction_code' => $transactionCode,
                'id_usercard' => $id_usercard,
                'total_amount' => $transaction->final_total
            ]);

            return [
                'success' => true,
                'message' => 'SiDiK transaction validated successfully',
                'response' => $res
            ];

        } catch (\Exception $e) {
            Log::error('Exception during SiDiK validation', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Cannot connect to SiDiK system: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get current store token
     */
    private function getCurrentStoreToken()
    {
        $currentStoreId = Session::get('mystore');
        
        if ($currentStoreId) {
            try {
                $storeToken = StoreToken::where('store_id', $currentStoreId)->first();
                return $storeToken ? $storeToken->token : null;
            } catch (\Exception $e) {
                Log::error('Error accessing store token in SellController: ' . $e->getMessage());
                return null;
            }
        }
        
        // Jika tidak ada store ID di session, coba ambil token pertama yang tersedia
        try {
            $storeToken = StoreToken::first();
            return $storeToken ? $storeToken->token : null;
        } catch (\Exception $e) {
            Log::error('Error accessing any store token in SellController: ' . $e->getMessage());
            return null;
        }
    }
}
