<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account\Expense;
use App\Models\Admin\Store;
use App\Models\Stock\StockAdjusmentDetail;
use App\Models\Transaction\Purchase;
use App\Models\Transaction\Sell;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfitController extends Controller
{
    // public function index(Request $request)
    // {
    //     $store = Store::all();
    //     $sellDiscount = Transaction::where('type', 'sell')->get();
    //     $profitsell = DB::table("sell_purchases as s_purchase")
    //         ->join("sells AS penjualan", "penjualan.id", "=", "s_purchase.sell_id")
    //         ->join("purchases AS pembelian", "pembelian.id", "=", "s_purchase.purchase_id")
    //         ->selectRaw("SUM((penjualan.unit_price * s_purchase.qty_return) - (pembelian.purchase_price * s_purchase.qty_return)) as dikembalikan,
    //                 SUM((penjualan.unit_price * s_purchase.qty) - (pembelian.purchase_price * s_purchase.qty)) AS terjual,
    //                 SUM(pembelian.purchase_price * s_purchase.qty) AS modal")
    //         ->first(); 
    //     $sellDisc = 0;
    //     foreach ($sellDiscount as $sd) {
    //         $sellDisc += $sd->total_before_tax * number_format($sd->discount_amount) / 100;
    //     }

    //     $data = [
    //         'total_purchase'    => Transaction::selectRaw('sum(final_total) as total')->where("type","purchase")->first(),
    //         'purchase_shipping' => Transaction::where('type', 'purchase')->sum('shipping_charges'),
    //         'purchase_discount' => Transaction::where('type', 'purchase')->sum('discount_amount'),

    //         'total_sell'        => Sell::selectRaw('sum(unit_price * qty) as total')->first(),
    //         'sell_shipping'     => Transaction::where('type', 'sell')->sum('shipping_charges'),
    //         'sell_discount'     => $sellDisc,

    //         'total_expense'     => Expense::sum('amount'),
    //         'transfer_shipping' => Transaction::where('type', 'stock_transfer')->sum('shipping_charges'),

    //         'stock_adjustment'  => StockAdjusmentDetail::selectRaw('sum(unit_price * qty_adjustment) as total')->first(),
    //         'amount_recovered'  => Transaction::where('type', 'stock_adjustment')->sum('total_amount_recovered'),
    //     ];
    //     if ($request->start_date || $request->store) {

    //         $sellDiscount = Transaction::where(function ($query) use ($request) {
    //             return $request->start_date ?
    //                 $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //         })->where(function ($query) use ($request) {
    //             return $request->store ?
    //                 $query->where('store_id', $request->store) : '';
    //         })->where('type', 'sell')->get();
    //         $sellDisc = 0;
    //         foreach ($sellDiscount as $sd) {
    //             $sellDisc += $sd->total_before_tax * number_format($sd->discount_amount) / 100;
    //         }

    //         $profitsell = DB::table("sell_purchases as s_purchase")
    //             ->join("sells AS penjualan", "penjualan.id", "=", "s_purchase.sell_id")
    //             ->join("purchases AS pembelian", "pembelian.id", "=", "s_purchase.purchase_id")
    //             ->selectRaw("SUM((penjualan.unit_price * s_purchase.qty_return) - (pembelian.purchase_price * s_purchase.qty_return)) as dikembalikan,
    //                         SUM(penjualan.unit_price * s_purchase.qty) AS terjual,
    //                         SUM(pembelian.purchase_price * s_purchase.qty) AS modal")
    //             ->where(function ($query) use ($request) {
    //                 return $request->start_date ? $query->whereBetween('s_purchase.created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ? $query->where('penjualan.store_id', $request->store) : '';
    //             })->first();

    //         $data = [
    //             'total_purchase'    => Purchase::where(function ($query) use ($request) {
    //                 return $request->start_date ?
    //                     $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ?
    //                     $query->where('store_id', $request->store) : '';
    //             })->selectRaw('sum(without_discount * quantity) as total')->first(),

    //             'purchase_shipping' => Transaction::where(function ($query) use ($request) {
    //                 return $request->start_date ?
    //                     $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ?
    //                     $query->where('store_id', $request->store) : '';
    //             })->where('type', 'purchase')->sum('shipping_charges'),

    //             'purchase_discount' => Transaction::where(function ($query) use ($request) {
    //                 return $request->start_date ?
    //                     $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ?
    //                     $query->where('store_id', $request->store) : '';
    //             })->where('type', 'purchase')->sum('discount_amount'),

    //             'total_sell'        => Sell::where(function ($query) use ($request) {
    //                 return $request->start_date ?
    //                     $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ?
    //                     $query->where('store_id', $request->store) : '';
    //             })->selectRaw('sum(unit_price * qty) as total')->first(),

    //             'sell_shipping'     => Transaction::where(function ($query) use ($request) {
    //                 return $request->start_date ?
    //                     $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ?
    //                     $query->where('store_id', $request->store) : '';
    //             })->where('type', 'sell')->sum('shipping_charges'),

    //             'sell_discount'     => $sellDisc,

    //             'total_expense'     => Expense::where(function ($query) use ($request) {
    //                 return $request->start_date ?
    //                     $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ?
    //                     $query->where('store_id', $request->store) : '';
    //             })->sum('amount'),

    //             'transfer_shipping' => Transaction::where(function ($query) use ($request) {
    //                 return $request->start_date ?
    //                     $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ?
    //                     $query->where('store_id', $request->store) : '';
    //             })->where('type', 'stock_transfer')->sum('shipping_charges'),

    //             'stock_adjustment'  => StockAdjusmentDetail::where(function ($query) use ($request) {
    //                 return $request->start_date ?
    //                     $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ?
    //                     $query->where('store_id', $request->store) : '';
    //             })->selectRaw('sum(unit_price * qty_adjustment) as total')->first(),

    //             'amount_recovered'  => Transaction::where(function ($query) use ($request) {
    //                 return $request->start_date ?
    //                     $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
    //             })->where(function ($query) use ($request) {
    //                 return $request->store ?
    //                     $query->where('store_id', $request->store) : '';
    //             })->where('type', 'stock_adjustment')->sum('total_amount_recovered'),
    //         ];
    //     }
    //     $sell = $data['total_sell']->total ?? 0;
    //     $purchase = $data['total_purchase']->total ?? 0;
    //     $adjustment = $data['stock_adjustment']->total ?? 0;
    //     $gross   = $sell - $purchase;
    //     $profit     = $gross + ($data['sell_shipping'] + $data['amount_recovered'] + $data['purchase_discount']) - ($adjustment + $data['total_expense'] + $data['purchase_shipping'] + $data['transfer_shipping'] + $data['sell_discount']);

    //     if ($request->ajax()) {
    //         return view('admin.reports.transaction.profit_page', ['page' => __('sidebar.profit_loss')], compact('data', 'gross', 'profit', 'store', 'profitsell'));
    //     }

    //     return view('admin.reports.transaction.loss_profit', ['page' => __('sidebar.profit_loss')], compact('data', 'gross', 'profit', 'store', 'profitsell'));
    // }
    public function index(Request $request)
{
    $store = Store::all();

    // Hitung diskon penjualan
    $sellDiscountQuery = Transaction::where('type', 'sell')
        ->when($request->store, fn($q) => $q->where('store_id', $request->store))
        ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
        ->get();

    $sellDisc = 0;
    foreach ($sellDiscountQuery as $sd) {
        $sellDisc += $sd->total_before_tax * ($sd->discount_amount / 100);
    }

    // Profit jual dari relasi pembelian-penjualan
    $profitsell = DB::table("sell_purchases as s_purchase")
        ->join("sells AS penjualan", "penjualan.id", "=", "s_purchase.sell_id")
        ->join("purchases AS pembelian", "pembelian.id", "=", "s_purchase.purchase_id")
        ->selectRaw("
            SUM((penjualan.unit_price * s_purchase.qty_return) - (pembelian.purchase_price * s_purchase.qty_return)) as dikembalikan,
            SUM((penjualan.unit_price * s_purchase.qty) - (pembelian.purchase_price * s_purchase.qty)) AS terjual,
            SUM(pembelian.purchase_price * s_purchase.qty) AS modal
        ")
        ->when($request->store, fn($q) => $q->where('penjualan.store_id', $request->store))
        ->when($request->start_date, fn($q) => $q->whereBetween('s_purchase.created_at', [$request->start_date, $request->end_date]))
        ->first();

    // Semua data transaksi
    $data = [
        // pembelian
        'total_purchase' => Transaction::selectRaw('SUM(final_total) as total')
            ->where('type', 'purchase')
            ->when($request->store, fn($q) => $q->where('store_id', $request->store))
            ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->first(),

        'purchase_shipping' => Transaction::where('type', 'purchase')
            ->when($request->store, fn($q) => $q->where('store_id', $request->store))
            ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->sum('shipping_charges'),

        'purchase_discount' => Transaction::where('type', 'purchase')
            ->when($request->store, fn($q) => $q->where('store_id', $request->store))
            ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->sum('discount_amount'),

        // penjualan
        'total_sell' => Sell::selectRaw('SUM(unit_price * qty) as total')
            ->when($request->store, fn($q) => $q->where('store_id', $request->store))
            ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->first(),

        'sell_shipping' => Transaction::where('type', 'sell')
            ->when($request->store, fn($q) => $q->where('store_id', $request->store))
            ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->sum('shipping_charges'),

        'sell_discount' => $sellDisc,

        // biaya
        'total_expense' => Expense::when($request->store, fn($q) => $q->where('store_id', $request->store))
            ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->sum('amount'),

        // transfer
        'transfer_shipping' => Transaction::where('type', 'stock_transfer')
            ->when($request->store, fn($q) => $q->where('store_id', $request->store))
            ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->sum('shipping_charges'),

        // stock adjustment
        'stock_adjustment' => StockAdjusmentDetail::selectRaw('SUM(unit_price * qty_adjustment) as total')
            ->when($request->store, fn($q) => $q->where('store_id', $request->store))
            ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->first(),

        'amount_recovered' => Transaction::where('type', 'stock_adjustment')
            ->when($request->store, fn($q) => $q->where('store_id', $request->store))
            ->when($request->start_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->sum('total_amount_recovered'),
    ];

    // Hitung gross & profit
    $sell       = $data['total_sell']->total ?? 0;
    $purchase   = $data['total_purchase']->total ?? 0;
    $adjustment = $data['stock_adjustment']->total ?? 0;

    $gross  = $sell - $purchase;
    $profit = $gross
        + ($data['sell_shipping'] + $data['amount_recovered'] + $data['purchase_discount'])
        - ($adjustment + $data['total_expense'] + $data['purchase_shipping'] + $data['transfer_shipping'] + $data['sell_discount']);

    if ($request->ajax()) {
        return view('admin.reports.transaction.profit_page', [
            'page' => __('sidebar.profit_loss'),
        ], compact('data', 'gross', 'profit', 'store', 'profitsell'));
    }

    return view('admin.reports.transaction.loss_profit', [
        'page' => __('sidebar.profit_loss'),
    ], compact('data', 'gross', 'profit', 'store', 'profitsell'));
}

}
