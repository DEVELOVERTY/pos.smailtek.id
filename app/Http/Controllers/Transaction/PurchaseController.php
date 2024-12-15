<?php

namespace App\Http\Controllers\Transaction;

use App\Exports\PurchaseExportDefaulth;
use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use App\Models\Admin\Taxrate;
use App\Models\Product\Product;
use App\Models\Product\Sku;
use App\Models\Product\Stock;
use App\Models\Product\Supplier;
use App\Models\Product\Variation;
use App\Models\Transaction\Purchase;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $data = Transaction::where('type', 'purchase')->orderBy('id', 'desc')->paginate(20);
        $status = [
            'received'      => __('purchase.received'),
            'ordered'       => __('purchase.ordered'),
            'pending'       => __('purchase.pending')
        ];

        $payment = [
            'due'   => __('general.po_due'),
            'paid'  => __('general.paid')
        ];

        $store = Store::all();
        $supplier = Supplier::all();
        if ($request->store != null || $request->supplier != null || $request->payment != null || $request->start_date || $request->status) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->supplier ?
                    $query->where('supplier_id', $request->supplier) : '';
            })->where(function ($query) use ($request) {
                return $request->payment ?
                    $query->where('payment_status', $request->payment) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->status ?
                    $query->where('status', $request->status) : '';
            })->where('type', 'purchase')->paginate(20);
            $data->appends([
                'store'  => $request->store,
                'supplier'  => $request->supplier,
                'payment' => $request->payment,
                'status'    => $request->status,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
        }

        if ($request->ajax()) {
            return view('admin.purchase.autoload_page', ['page' => __('sidebar.purchase')], compact('data', 'store', 'supplier', 'status', 'payment'));
        }
        return view('admin.purchase.index', ['page' =>  __('sidebar.purchase')], compact('data', 'store', 'supplier', 'status', 'payment'));
    }

    public function create()
    {
        $data = [
            'supplier'      => Supplier::orderBy('name', 'desc')->get(),
            'taxrate'       => Taxrate::all(),
            'status'        => [
                'received'      => __('received'),
                'ordered'       => __('order'),
                'pending'       => __('pending')
            ],
            'payment_method' => [
                'cash'          => 'Cash',
                'bank_transfer' => 'Bank Transfer',
                'card'          => 'Card',
            ],
        ];

        return view('admin.purchase.create', ['page' => __('sidebar.add_purchase')], compact('data'));
    }

    public function getProduct(Request $request)
    {
        $response = array();
        if ($request->term != null) {
            $getdata = Product::where('name', 'like', '%' . $request->term . '%')->limit(20)->get();
            foreach ($getdata as $product) {
                foreach ($product->variant as $v) {
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
            return response()->json($response);
        } else {
            $getdata = Product::limit(20)->get();
            foreach ($getdata as $product) {
                foreach ($product->variant as $v) {
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
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id'        => 'required',
            'status'             => 'required',

            "qty"    => "required|array|min:0",
            "qty.*"  => "required|min:0",

            "unit_cost"    => "required|array|min:0",
            "unit_cost.*"  => "required|min:0",

            "discount_percent"    => "required|array|min:0",
            "discount_percent.*"  => "required|min:0",

            "unit_cost_adiscount"    => "required|array|min:0",
            "unit_cost_adiscount.*"  => "required|min:0",

            "selling_price"    => "required|array|min:0",
            "selling_price.*"  => "required|min:0",

            "ref_no"             => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new Transaction();
        $data->store_id = Session::get('mystore');
        $data->type     = 'purchase';
        $data->status   = $request->status;
 
        if ($request->payment_due == 0) {
            $data->payment_status = 'paid';
        } else { 
            $data->payment_status = 'due';
        }

        $data->supplier_id  = $request->supplier_id;
        $data->created_by   = Auth()->user()->id;
        $data->invoice_no   = rand();
        $data->ref_no       = $request->ref_no;
        $data->transaction_date = date('Y-m-d');

        $jumlah = 0;
        foreach ($request->line_total as $total) {
            $jumlah = +Helper::fresh_aprice($total);
        }

        $data->total_before_tax = $jumlah;
        $data->tax_amount       = $request->tax_po;

        if ($request->discount_amount) {
            $data->discount_type    = $request->type_discount;
            $data->discount_amount  = $request->discount_amount;
        }

        $request->shipping_details ? $data->shipping_details = $request->shipping_details : null;
        $request->shipping_charges ? $data->shipping_charges = Helper::fresh_aprice($request->shipping_charges) : null;
        $request->additional_note ? $data->additional_notes = $request->additional_note : null;
        $data->final_total = $request->net_total;
        $data->save();

        $num = count($request->line_total);
        for ($x = 0; $x < $num; $x++) {
            $purchase = new Purchase();
            $purchase->transaction_id = $data->id;
            $purchase->store_id       = $data->store_id;
            $purchase->product_id     = $request->product_id[$x];
            $purchase->variation_id   = $request->variant_id[$x];
            $purchase->quantity       = $request->qty[$x];
            $purchase->discount_percent = $request->discount_percent[$x];
            $purchase->purchase_price          = Helper::fresh_aprice($request->unit_cost_adiscount[$x]);
            $purchase->without_discount        = Helper::fresh_aprice($request->unit_cost[$x]);
            $purchase->purchase_price_inc_tax = Helper::fresh_aprice($request->unit_cost_atax[$x]);
            $purchase->item_tax       = $request->tax_price[$x];
            $purchase->save();

            $getVariation = Variation::findOrFail($request->variant_id[$x]);
            $getVariation->purchase_price = Helper::fresh_aprice($request->unit_cost[$x]);
            $getVariation->save();
        }

        if ($request->payment_amount) {
            $payment = new TransactionPayment();
            $payment->transaction_id    = $data->id;
            $payment->amount            = Helper::fresh_aprice($request->payment_amount);
            $payment->method            = $request->payment_method;
            $request->payment_note ? $payment->note = $request->payment_note : null;
            if ($request->payment_method == 'bank_transfer') {
                $request->no_rek ? $payment->no_rek = $request->no_rek : null;
                $request->an ? $payment->an = $request->an : null;
                $request->bank_id ? $payment->bank_id = $request->bank_id : null;
            } else if ($request->payment_method == 'card') {
                $request->card_number ? $payment->card_number = $request->card_number : null;
                $request->card_holder_name ? $payment->card_holder_name = $request->card_holder_name : null;
                $request->card_transaction_number ? $payment->card_transaction_number = $request->card_transaction_number : null;
                $request->card_type ? $payment->card_type = $request->card_type : null;
                $request->card_month ? $payment->card_month = $request->card_month : null;
                $request->card_year ? $payment->card_year = $request->card_year : null;
                $request->card_security ? $payment->card_security = $request->card_security : null;
            }
            $payment->save();
        }

        if ($request->status == 'received') {
            $baru = count($request->line_total);
            for ($y = 0; $y < $baru; $y++) {
                $CheckSkus = Stock::where('product_id', $request->product_id[$y])->where('variation_id', $request->variant_id[$y])->where('store_id', Session::get('mystore'))->first();
                if ($CheckSkus == null) {
                    $skus = new Stock();
                    $skus->qty_available          = $request->qty[$y];
                } else {
                    $skus = Stock::findOrFail($CheckSkus->id);
                    $skus->qty_available          = $skus->qty_available +  $request->qty[$y];
                }
                $skus->product_id     = $request->product_id[$y];
                $skus->variation_id   = $request->variant_id[$y];
                $skus->store_id       = $data->store_id;
                $skus->save();
            }
        }


        return redirect()->route('purchase.index')->with(['flash' => __('alert.created')]);
    }

    public function purchasePay(Request $request)
    {
        $this->validate($request, [
            'payment_amount'        => 'required',
        ]);
        $payment = new TransactionPayment();
        $payment->transaction_id    = $request->transaction_id;
        $payment->amount            = $request->payment_amount;
        $payment->method            = $request->payment_method;
        $request->payment_note ? $payment->note = $request->payment_note : null;
        if ($request->payment_method == 'bank_transfer') {
            $request->no_rek ? $payment->no_rek = $request->no_rek : null;
            $request->an ? $payment->an = $request->an : null;
            $request->bank_id ? $payment->bank_id = $request->bank_id : null;
        } else if ($request->payment_method == 'card') {
            $request->card_number ? $payment->card_number = $request->card_number : null;
            $request->card_holder_name ? $payment->card_holder_name = $request->card_holder_name : null;
            $request->card_transaction_number ? $payment->card_transaction_number = $request->card_transaction_number : null;
            $request->card_type ? $payment->card_type = $request->card_type : null;
            $request->card_month ? $payment->card_month = $request->card_month : null;
            $request->card_year ? $payment->card_year = $request->card_year : null;
            $request->card_security ? $payment->card_security = $request->card_security : null;
        }
        return $this->saveData($payment);
    }

    public function domVariantItem($id)
    {
        $getData    = Variation::findOrFail($id);
        $getTax     = Taxrate::all();

        return response()->json([
            'product' => [
                'name'      => $getData->product->name . ' - ' . $getData->name,
                'id'        => $getData->id,
                'pname'     => $getData->product->name,
                'pid'       => $getData->product->id,
                'margin'    => $getData->margin,
                'p_price'   => $getData->purchase_price,
                's_price'   => $getData->selling_price,
                'stock'     => $getData->stock_total,
            ],
            'taxrate'       => $getTax,
        ]);
    }

    public function getTax($id)
    {
        $data = Taxrate::where("id", $id)->first();
        if ($data == null) {
            return 0;
        } else {
            return $data->taxrate;
        }
    }

    public function detail($id)
    {
        $status = [
            'received'      => __('purchase.received'),
            'ordered'       => __('purchase.ordered'),
            'pending'       => __('purchase.pending')
        ];

        $payment = [
            'due'   => __('general.po_due'),
            'paid'  => __('general.paid')
        ];

        $purchase = Transaction::findOrFail($id);
        $getDetail = Purchase::where('transaction_id', $id)->get();
        return view('admin.purchase.detail', ['page' => __('purchase.detail')], compact('getDetail', 'purchase', 'status', 'payment'));
    }

    public function printInvoice($id)
    {

        $status = [
            'received'      => __('purchase.received'),
            'ordered'       => __('purchase.ordered'),
            'pending'       => __('purchase.pending')
        ];

        $payment = [
            'due'   => __('general.po_due'),
            'paid'  => __('general.paid')
        ];
        $purchase = Transaction::findOrFail($id);
        $getDetail = Purchase::where('transaction_id', $id)->get();
        return view('admin.purchase.print_invoice', ['page' => __('purchase.detail')], compact('getDetail', 'purchase', 'status', 'payment'));
    }


    public function updateStatus(Request $request)
    {
        $this->validate($request, [
            'status'    => 'required'
        ]);

        $data = Transaction::findOrFail($request->id);
        $data->status = $request->status;
        $data->save();

        foreach ($data->purchase as $p) {
            $CheckSkus = Stock::where('product_id', $p->product_id)->where('variation_id', $p->variation_id)->where('store_id', Session::get('mystore'))->first();
            if ($CheckSkus == null) {
                $skus = new Stock();
                $skus->qty_available          = $p->quantity;
            } else {
                $skus = Stock::findOrFail($CheckSkus->id);
                $skus->qty_available          = $skus->qty_available +  $p->quantity;
            }
            $skus->product_id     = $p->product_id;
            $skus->variation_id   = $p->variation_id;
            $skus->store_id       = $data->store_id;
            $skus->save();
        }
        return $this->saveData($data);
    }

    public function updatePayment(Request $request)
    {
        $this->validate($request, [
            'payment_status'    => 'required'
        ]);

        $data = Transaction::findOrFail($request->id);
        $data->payment_status = $request->payment_status;
        return $this->saveData($data);
    }

    public function report(Request $request)
    {
        $data = Transaction::where('type', 'purchase')->orderBy('id', 'desc')->paginate(20);
        $our = Transaction::where('type', 'purchase')->orderBy('id', 'desc')->get();
        $store = Store::all();
        $supplier = Supplier::all();
        $status = [
            'received'      => __('purchase.received'),
            'ordered'       => __('purchase.ordered'),
            'pending'       => __('purchase.pending')
        ];

        $payment = [
            'due'   => __('general.po_due'),
            'paid'  => __('general.paid')
        ];
        $jumlahTotal = 0;
        $jumlahHutang = 0;
        $jumlahTerbayar = 0;
        foreach ($our as $d) {
            $jumlahTotal += $d->final_total;
            $jumlahHutang += $d->due_total;
            $jumlahTerbayar += Helper::fresh_aprice($d->pay_total);
        }
        if ($request->store != null || $request->supplier != null || $request->payment != null || $request->start_date || $request->status) {
            $data = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->supplier ?
                    $query->where('supplier_id', $request->supplier) : '';
            })->where(function ($query) use ($request) {
                return $request->payment ?
                    $query->where('payment_status', $request->payment) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->status ?
                    $query->where('status', $request->status) : '';
            })->where('type', 'purchase')->paginate(20);
            $our = Transaction::where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->where(function ($query) use ($request) {
                return $request->supplier ?
                    $query->where('supplier_id', $request->supplier) : '';
            })->where(function ($query) use ($request) {
                return $request->payment ?
                    $query->where('payment_status', $request->payment) : '';
            })->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->status ?
                    $query->where('status', $request->status) : '';
            })->where('type', 'purchase')->get();
            $data->appends([
                'store'  => $request->store,
                'supplier'  => $request->supplier,
                'payment' => $request->payment,
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
            return view('admin.reports.transaction.purchase_page', ['page' => __('sidebar.purchase_report')], compact(
                'data',
                'store',
                'supplier',
                'jumlahTotal',
                'jumlahHutang',
                'jumlahTerbayar',
                'status',
                'payment'
            ));
        }
        return view('admin.reports.transaction.purchase', ['page' => __('sidebar.purchase_report')], compact(
            'data',
            'store',
            'supplier',
            'jumlahTotal',
            'jumlahHutang',
            'jumlahTerbayar',
            'status',
            'payment'
        ));
    }

    public function download()
    {
        return Excel::download(new PurchaseExportDefaulth(), 'laporan_purchase.xlsx');
    }
}
