<?php

namespace App\Http\Controllers\Product;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Admin\Store;
use App\Models\Admin\Taxrate;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductVariation;
use App\Models\Product\Stock;
use App\Models\Product\Supplier;
use App\Models\Product\Unit;
use App\Models\Product\Variation;
use App\Models\Transaction\Purchase;
use App\Models\Transaction\Sell;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\VariantImport;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data = Product::orderBy('name', 'asc')->paginate(20);
        $unit = Unit::all();
        $brand = Brand::all();
        if ($request->name != null || $request->unit != null || $request->brand != null) {

            $data = Product::where(function ($query) use ($request) {
                return $request->name ?
                    $query->where('name', 'like', '%' . $request->name . '%') : '';
            })->orWhere(function ($query) use ($request) {
                return $request->unit ?
                    $query->where('unit_id', $request->unit) : '';
            })->orWhere(function ($query) use ($request) {
                return $request->brand ?
                    $query->where('brand_id', $request->brand) : '';
            })->paginate(20);
            $data->appends([
                'name'  => $request->name,
                'unit'  => $request->unit,
                'brand' => $request->brand
            ]);
        }

        if ($request->ajax()) {
            return view('admin.product.autoload_page', ['page' => __('sidebar.product')], compact('data', 'unit', 'brand'));
        }
        return view('admin.product.index', ['page' => __('sidebar.product')], compact('data', 'unit', 'brand'));
    }


    public function create()
    {
        $data = [
            'category'  => Category::where('parent_id', null)->orderBy('name', 'asc')->get(),
            'unit'      => Unit::all(),
            'brand'     => Brand::all(),
            'tax'       => Taxrate::all(),
            'variant'   => ProductVariation::all(),
            'tax_type'  => array(
                'inclusive' => 'Inclusive',
                'exclusive' => 'Exclusive'
            ),
            'barcode'   => array(
                'c128'  => 'Code 128 (C128)',
                'c39'   => 'Code 39 (C39)',
                'ean13' => 'EAN-13',
                'ean8'  => 'EAN-8',
                'upcA'  => 'UPC-A',
                'upcE'  => 'UPC-E'
            )

        ];

        return view('admin.product.create', ['page' => __('sidebar.add_product')], compact('data'));
    }

    public function getSubcategory($id)
    {
        $data   = '<option value=""> ' . __('choose') . ' ' . __('subcategory') . '</option>';
        $getData = Category::where('parent_id', $id)->get();
        foreach ($getData as $c) {
            $data .= '<option value=" ' . $c->id . '"> ' . $c->name . '</option>';
        }
        echo $data;
    }

    public function getVariation($id)
    {
        $getData    = ProductVariation::findOrFail($id);
        return response()->json([
            'variant' => $getData->value,
            'message' => __('success')
        ]);
    }

    public function update($id)
    {
        $product        = Product::findOrFail($id);
        $data = [

            'category'  => Category::where('parent_id', null)->orderBy('name', 'asc')->get(),
            'unit'      => Unit::all(),
            'brand'     => Brand::all(),
            'tax'       => Taxrate::all(),
            'variant'   => ProductVariation::all(),
            'tax_type'  => array(
                'inclusive' => 'Inclusive',
                'exclusive' => 'Exclusive'
            ),
            'barcode'   => array(
                'c128'  => 'Code 128 (C128)',
                'c39'   => 'Code 39 (C39)',
                'ean13' => 'EAN-13',
                'ean8'  => 'EAN-8',
                'upcA'  => 'UPC-A',
                'upcE'  => 'UPC-E'
            )

        ];

        return view('admin.product.update', ['page' => __('produk.update')], compact('data', 'product'));
    }

    public function delete($id)
    {
        $getData = Product::findOrFail($id);
        foreach ($getData->variant as $variant) {
            $this->deleteData($variant, $variant->id);
        }
        return $this->deleteData($getData, $id);
    }

    public function deleteVariation($id)
    {
        $data = Variation::findOrFail($id);
        return $this->deleteData($data, $id);
    }

    public function store(Request $request, $condition)
    {
        $this->validate($request, [
            'name'      => 'required',
            'sku_product'       => 'required',
            'type'      => 'required',
            'image'     => 'mimes:jpg,png,jpeg',
            'category'  => 'required',
            'brand_id'  => 'required',
            'unit_id'   => 'required',
            'barcode_type' => 'required',
        ]);

        if ($request->type == 'single') {

            $this->validate($request, [
                'p_price'       => 'required',
                's_price'       => 'required',
                'mrg'           => 'required',
                'img'           => 'mimes:jpg,jpeg,png'
            ]);
        } else {

            $validator = Validator::make($request->all(), [
                "value"    => "required|array|min:0",
                "value.*"  => "required|min:0",

                "purchase_price"    => "required|array|min:0",
                "purchase_price.*"  => "required|min:0",

                "margin"    => "required|array|min:0",
                "margin.*"  => "required|min:0",

                "selling_price"    => "required|array|min:0",
                "selling_price.*"  => "required|min:0",
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $condition == 'create' ? $data = new Product : $data = Product::findOrFail($request->id);
        $data->name                 = $request->name;
        $data->sku                  = $request->sku_product;
        $data->type                 = $request->type;
        $request->subcategory ? $data->category_id = $request->subcategory : $data->category_id = $request->category;
        $data->brand_id             = $request->brand_id;
        $data->unit_id              = $request->unit_id;
        $data->barcode_type         = $request->barcode_type;
        $request->alert_quantity ? $data->alert_quantity = $request->alert_quantity : $data->alert_quantity = 0;
        $request->weight ? $data->weight = $request->weight : $data->weight = 0;
        $request->custom_field1 ? $data->custom_field1 = $request->custom_field1 : null;
        $request->custom_field2 ? $data->custom_field2 = $request->custom_field2 : null;
        $request->custom_field3 ? $data->custom_field3 = $request->custom_field3 : null;
        $request->custom_field4 ? $data->custom_field4 = $request->custom_field4 : null;
        $request->description ? $data->description = clean($request->description) : null;
        $request->image ? $data->image = $this->uploadImage($request, 'image', 'product/' . strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $request->name))) : null;
        $data->save();

        if ($request->type == 'single') {
            $condition == 'create' ? $variation = new Variation : $variation = Variation::findOrFail($request->variant_id);
            if ($condition == 'create') {
                $request->sku_ ? $variation->sku = $request->sku_ : $variation->sku = $this->generateEAN();
            } else {
                $request->sku_ ? $variation->sku = $request->sku_ : $variation->sku = $variation->sku;
            }
            $variation->product_id      = $data->id;
            $variation->price_inc_tax   = Helper::fresh_aprice($request->p_price);
            $variation->purchase_price  = Helper::fresh_aprice($request->p_price);
            $variation->selling_price   = Helper::fresh_aprice($request->s_price);
            $variation->margin          = $request->mrg;
            $variation->save();
            if (isset($request->img)) {
                $variation->media()->firstOrNew()->saveImage(base64_encode($request->img->get()), [
                    'path' => "uploads/product/" . strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $request->name)) . "/{sku}",
                    'resize' => true,
                ]);
            }
        } elseif ($request->type == 'variable') {
            $num = count($request->value);
            for ($x = 0; $x < $num; $x++) {
                if ($request->variation_id[$x] != null) {
                    $variasi = Variation::findOrFail($request->variation_id[$x]);
                    $request->sku[$x] ? $variasi->sku = $request->sku[$x] : $variasi->sku = $this->generateEAN();
                } else {
                    $variasi = new Variation;
                    $request->sku[$x] ? $variasi->sku = $request->sku[$x] : $variasi->sku = $this->generateEAN();
                }

                if ($request->value_id[$x] != null) {
                    $variasi->variation_value_id          = $request->value_id[$x];
                }
                $variasi->product_id        = $data->id;
                $variasi->name              = $request->value[$x];
                $variasi->purchase_price    = Helper::fresh_aprice($request->purchase_price[$x]);
                $variasi->selling_price     = Helper::fresh_aprice($request->selling_price[$x]);
                $variasi->price_inc_tax     = Helper::fresh_aprice($request->purchase_price[$x]);
                $variasi->margin            = $request->margin[$x];
                $variasi->save();

                if (isset($request->im[$x])) {
                    $variasi->media()->firstOrNew()->saveImage(base64_encode($request->im[$x]->get()), [
                        'path' => "uploads/product/" . strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $request->name)) . "/{sku}",
                        'resize' => true,
                    ]);
                }
            }
        }

        return redirect()->back()->with(['flash' => __('success')]);
    }

    function generateEAN()
    {
        $code = '200' . str_pad($this->generateRandomCode(), 9, '0');
        $weightflag = true;
        $sum = 0;
        for ($i = strlen($code) - 1; $i >= 0; $i--) {
            $sum += (int)$code[$i] * ($weightflag ? 3 : 1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;
        return $code;
    }

    function generateRandomCode($length = 8)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function printBarcode()
    {
        return view('admin.product.barcode', ['page' => __('produk.print_label')]);
    }

    public function printBar(Request $request)
    {
        $option = $request->all();
        $store = Store::findOrFail(Session::get('mystore'));
        $num = count($request->variant_id);
        $array = [];
        for ($x = 0; $x < $num; $x++) {
            $array[$request->variant_id[$x]] = $request->total[$x];
        }

        $product = [];
        foreach ($array as $a => $jumlah) {
            $getVar = Variation::findOrFail($a);
            $total = $jumlah;
            isset($request->variation_product) ? $name = $getVar->product->name . ' - ' . $getVar->name : $name = $getVar->product->name;
            for ($x = 0; $x < $total; $x++) {
                $get = array(
                    'name'      => $name,
                    'id'        => $getVar->id,
                    'pname'     => $getVar->product->name,
                    'barcode'   => $getVar->sku,
                    'type'      => $getVar->product->barcode_type,
                    'price'     => number_format($getVar->selling_price)
                );
                array_push($product, $get);
            }
        }
        return view('admin.product.printb', ['page' => __('produk.print_label')], compact('product', 'option', 'store'));
    }

    public function poLabel($transactionID)
    {
        $data = Transaction::findOrFail($transactionID);
        return view('admin.product.purchase_label', ['page' => __('produk.print_label')], compact('data'));
    }

    public function openStock($id)
    {
        $data = Product::findOrFail($id);
        $getOpening = Transaction::where("type", "open_stock")->where("open_stock_product_id", $id)->first();
        if ($getOpening == null) {
            return view("admin.product.open_stock", ['page' => __('produk.open_stock')], compact('data'));
        }

        return view("admin.product.update_open_stock", ["page" =>  __('produk.open_stock')], compact('data', 'getOpening'));
    }

    public function openStockStore(Request $request, $condition)
    {
        $validator = Validator::make($request->all(), [

            "qty_opening"    => "required|array|min:0",
            "qty_opening.*"  => "required|min:0",

            "variation_id"    => "required|array|min:0",
            "variation_id.*"  => "required|min:0",

            "opening_subtotal"    => "required|array|min:0",
            "opening_subtotal.*"  => "required|min:0",

            "ref_no"             => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $condition == 'create' ? $data = new Transaction() : $data = Transaction::findOrFail($request->id);
        $data->store_id = Session::get('mystore');
        $data->type     = 'open_stock';
        $data->status   = 'received';
        $data->payment_status = 'paid';
        $data->created_by   = Auth()->user()->id;
        $data->invoice_no   = rand();
        $data->ref_no       = $request->ref_no;
        $data->transaction_date = date('Y-m-d');

        $data->total_before_tax = $request->amount_total;
        $data->tax_amount       = 0;
        $data->open_stock_product_id = $request->product_id;
        $data->final_total = $request->amount_total;
        $data->save();

        $num = count($request->variation_id);
        for ($x = 0; $x < $num; $x++) {

            $getPO = Purchase::where("transaction_id", $data->id)
                ->where("product_id", $data->open_stock_product_id)
                ->where("variation_id", $request->variation_id[$x])
                ->first();

            $CheckSkus = Stock::where('product_id', $data->open_stock_product_id)
                ->where('variation_id', $request->variation_id[$x])
                ->where('store_id', $data->store_id)->first();
            if ($CheckSkus == null) {
                $skus = new Stock();
                $skus->qty_available          = $request->qty_opening[$x];
            } else {
                $skus = Stock::findOrFail($CheckSkus->id);
                if ($getPO == null) {
                    $skus->qty_available          = $skus->qty_available +  $request->qty_opening[$x];
                } else {
                    if ($getPO->quantity < $request->qty_opening[$x]) {
                        $quantity = $request->qty_opening[$x] - $getPO->quantity;
                        $skus->qty_available          = $skus->qty_available +  $quantity;
                    } elseif ($getPO->quantity > $request->qty_opening[$x]) {
                        $quantity =  $getPO->quantity - $request->qty_opening[$x];
                        if ($getPO->qty_sold > $request->qty_opening[$x]) {
                            return back()->with(['gagal' => __('produk.sorry_open_stock') . ' ' . $getPO->product->name . ' ' . $getPO->variation->name . ' ' . __('produk.sorry_open_stock1')]);
                        }
                        $skus->qty_available          = $skus->qty_available -  $quantity;
                    } else {
                        $skus->qty_available          = $skus->qty_available;
                    }
                }
            }

            $getPO == null ? $purchase = new Purchase() : $purchase = Purchase::findOrFail($getPO->id);
            $purchase->transaction_id = $data->id;
            $purchase->store_id       = $data->store_id;
            $purchase->product_id     = $data->open_stock_product_id;
            $purchase->variation_id   = $request->variation_id[$x];
            $purchase->quantity       = $request->qty_opening[$x];
            $purchase->discount_percent = 0;
            $purchase->purchase_price          = $request->pricing[$x];
            $purchase->without_discount        = $request->pricing[$x];
            $purchase->purchase_price_inc_tax = $request->pricing[$x];
            $purchase->item_tax       = 0;
            $purchase->save();


            $skus->product_id     = $data->open_stock_product_id;
            $skus->variation_id   = $request->variation_id[$x];
            $skus->store_id       = $data->store_id;
            $skus->save();
        }


        return redirect()->route("product.opening", $data->open_stock_product_id);
    }

    public function topProduct(Request $request)
    {
        $data = Sell::with(['variation', 'product'])->selectRaw('sum(qty) as quantity, variation_id as variation, store_id as store')
            ->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->groupBy('variation', 'store')->first();
        if ($data != null) {
            $variation = Variation::where("id",$data->variation)->first();
        } else {
            $variation = null;
        }

        $five = Sell::with(['variation', 'product'])->selectRaw('sum(qty) as quantity, variation_id as variation, store_id as store')
            ->where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id', $request->store) : '';
            })->groupBy('variation', 'store')
            ->groupBy('variation')->orderBy('quantity', 'desc')->limit(10)->get();

        $product = array();
        foreach ($five as $f) {
            $variant = Variation::where("id",$f->variation)->first();
            if($variant != null) {
                $pname = $variant->product->name ?? '';
                if ($variant->name != 'no-name') {
                    $name = $pname . ' - ' . $variant->name;
                } else {
                    $name = $pname;
                }
                $list = [
                    'name'  => $name,
                    'selling'  => $f->quantity,
                    'unit_price' => $variant->selling_price,
                    'image' => $variant->gambar->path ?? '/uploads/image.jpg',
                ];
                array_push($product, $list);
            }
           
        }
        return view('admin.reports.stock.top_product', ['page' => 'Top Product'], compact('product', 'variation', 'data'));
    }

    public function stockReport(Request $request)
    {
        $data =  DB::table("variations as v")
            ->join("stocks as s", "v.id", "=", "s.variation_id")
            ->join("products as p", "v.product_id", "=", "p.id")
            ->join("stores as st", "s.store_id", "=", "st.id")
            ->selectRaw("p.name AS product_name, v.name AS variation_name, s.store_id AS store, s.qty_available AS stok,st.name AS store_name")
            ->paginate(20);

        $store = Store::all();

        if ($request->name != null || $request->store != null) {
            $data = DB::table("variations as v")
                ->join("stocks as s", "v.id", "=", "s.variation_id")
                ->join("products as p", "v.product_id", "=", "p.id")
                ->join("stores as st", "s.store_id", "=", "st.id")
                ->selectRaw("p.name AS product_name, v.name AS variation_name, s.store_id AS store, s.qty_available AS stok, st.name AS store_name")
                ->where(function ($query) use ($request) {
                    return $request->store ?
                        $query->where('s.store_id', $request->store) : '';
                })->orWhere(function ($query) use ($request) {
                    return $request->name ?
                        $query->where('p.name', 'like', '%' . $request->name . '%') : '';
                })->orWhere(function ($query) use ($request) {
                    return $request->name ?
                        $query->where('v.name', 'like', '%' . $request->name . '%') : '';
                })->paginate(20);

            $data->appends([
                'store'  => $request->store,
                'name'  => $request->customer,
            ]);
        }

        if ($request->ajax()) {
            return view('admin.reports.stock.all_page', ['page' => __('sidebar.all_stock')], compact(
                'data',
                'store'
            ));
        }

        return view('admin.reports.stock.all', ['page' => __('sidebar.all_stock')], compact(
            'data',
            'store'
        ));
    }

    public function productimport()
    {
        return view('admin.product.import', ["page" => "Product Import"]);
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file'  => 'mimes:xlsx'
        ]);

        if ($request->file) {
            $file = $this->uploadImage($request, 'file', 'import'); 
            $import = Excel::import(new ProductImport(), $file);
            if($import) { 
                return redirect()->back()->with(['flash' => "Import Data Berhasil"]);
            } else {
                //redirect
                return redirect()->back()->with(['gagal' => "Terjadi kesalahan"]);
            }
        }

        return back()->with(['gagal' => 'Maaf, File Import Tidak Terbaca']);
    }

    public function import_variant(Request $request)
    {
        $this->validate($request, [
            'file'  => 'mimes:xlsx'
        ]);

        if ($request->file_variant) {
            $file = $this->uploadImage($request, 'file_variant', 'import'); 
            $import = Excel::import(new VariantImport(), $file);
            if($import) { 
                return redirect()->back()->with(['flash' => "Import Data Berhasil"]);
            } else {
                //redirect
                return redirect()->back()->with(['gagal' => "Terjadi kesalahan"]);
            }
        }

        return back()->with(['gagal' => 'Maaf, File Import Tidak Terbaca1']);
    }



}
