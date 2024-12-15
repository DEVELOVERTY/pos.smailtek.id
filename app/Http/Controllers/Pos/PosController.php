<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use App\Models\Admin\Setting;
use App\Models\Admin\Store;
use App\Models\Product\Product;
use App\Models\Product\Stock;
use App\Models\Product\Variation;
use App\Models\Transaction\Sell;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use charlieuki\ReceiptPrinter\Item as Item;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Jenssegers\Agent\Agent;

class PosController extends Controller
{
    private $items;
    private $currency = 'Rp';

    public function index()
    {
        $agent = new Agent();
        if($agent->isMobile()) {
            return view('pos.mobile',["page" => "Pos Mobile"]);
        }
        return view('pos.index', ['page' => 'POS']);
    }

    public function product()
    {
        $data = Variation::with('media')->get();
        $product = array();
        foreach ($data as $p) {
            $getStock = Stock::where('product_id', $p->product_id)->where('store_id', Session::get('mystore'))->where('variation_id', $p->id)->sum('qty_available');
            if ($getStock <= 0) {
            } else {
                $list = array(
                    'id'    => $p->id,
                    'name'  => $p->product->name . ' - ' . $p->name,
                    'barcode' => $p->sku,
                    'price' => number_format($p->selling_price),
                    'image' => asset($p->gambar->path ?? '/uploads/image.jpg'),
                    'options' => null,
                    'stock' => $getStock
                );
                array_push($product, $list);
            }
        }
        return response()->json([
            'products' => $product,
            'message' => __('success')
        ]);
    }

    public function byCategory($id)
    {
        $data = Variation::with('media')->get();
        $product = array();
        foreach ($data as $p) {
            $getStock = Stock::where('product_id', $p->product_id)->where('store_id', Session::get('mystore'))->where('variation_id', $p->id)->sum('qty_available');
            $getProduct = Product::where('id', $p->product_id)->where('category_id', $id)->count();
            if ($id != 'all') {
                if ($getStock <= 0 || $getProduct == 0) {
                } else {
                    $list = array(
                        'id'    => $p->id,
                        'name'  => $p->product->name . ' - ' . $p->name,
                        'barcode' => $p->sku,
                        'price' => number_format($p->selling_price),
                        'image' => asset($p->gambar->path ?? '/uploads/image.jpg'),
                        'options' => null,
                        'stock' => $getStock
                    );
                    array_push($product, $list);
                }
            } else {
                if ($getStock < 0) {
                } else {
                    $list = array(
                        'id'    => $p->id,
                        'name'  => $p->product->name . ' - ' . $p->name,
                        'barcode' => $p->sku,
                        'price' => number_format($p->selling_price),
                        'image' => asset($p->gambar->path ?? '/uploads/image.jpg'),
                        'options' => null,
                        'stock' => $getStock
                    );
                    array_push($product, $list);
                }
            }
        }
        return response()->json([
            'products' => $product,
            'message' => __('success')
        ]);
    }

    public function getProduct($id)
    {
        $data = Variation::where("id", $id)->orWhere("sku", $id)->first();
        $product = array();

        $getStock = Stock::where('product_id', $data->product_id)->where('store_id', Session::get('mystore'))->where('variation_id', $data->id)->sum('qty_available');
        if ($getStock < 0) {
            return response()->json([
                'products' => $product,
                'message' => 'error'
            ]);
        } else {
            $list = array(
                'id'    => $data->id,
                'product_id' => $data->product_id,
                'name'  => substr($data->product->name . ' - ' . $data->name, 0, 16) . "....",
                'price' => number_format($data->selling_price),
                'fullname' => $data->product->name . ' - ' . $data->name,
                'tprice' => $data->selling_price,
                'options' => null,
                'stock' => number_format($getStock)
            );
            array_push($product, $list);
        }

        return response()->json([
            'product' => $product,
            'message' => __('success')
        ]);
    }

    public function customer()
    {
        $data   = '';
        $getData = Customer::orderBy('id', 'desc')->get();
        foreach ($getData as $c) {
            $data .= '<option value=" ' . $c->id . '"> ' . $c->name . '</option>';
        }
        echo $data;
    }

    public function getHold()
    {
        $data = Transaction::where('type', 'sell')
            ->where('status', 'hold')
            ->get();
        $transaction = array();
        foreach ($data as $d) {
            $list = array(
                'id'    => $d->id,
                'products'  => count($d->sell),
                'invoice' => $d->invoice_no,
                'customer' => $d->customer->name
            );
            array_push($transaction, $list);
        }

        return response()->json([
            'transaction' => $transaction,
            'message' => __('success')
        ]);
    }

    public function getbill($id)
    {
        $data = Transaction::findOrFail($id);
        $product = array();
        foreach ($data->sell as $d) {
            $getStock = Stock::where('product_id', $d->product_id)->where('store_id', Session::get('mystore'))->where('variation_id', $d->variation_id)->sum('qty_available');
            $tprice = $d->unit_price * $d->qty;
            $list = array(
                'id'        => $d->variation_id,
                'bill_id'   => $d->id,
                'product_id' => $d->product_id,
                'qty_product'   => $d->qty,
                'name'  => substr($d->product->name . ' - ' . $d->variation->name, 0, 16) . "....",
                'price' => number_format($d->unit_price),
                'tprice' => $tprice,
                'unitprice' => $d->unit_price,  
                'options' => null,
                'stock' => $getStock
            );
            array_push($product, $list);
        }
        return response()->json([
            'bill' => $product,
            'other' => $data,
            'message' => __('success')
        ]);
    }

    public function deleteBill($id)
    {
        $data = Sell::findOrFail($id);
        return $this->deleteData($data, $id);
    }

    public function printReceipt($id)
    {
        $data = Transaction::findOrFail($id);
        $store = Store::findOrFail(Session::get('mystore'));
        $settings = Setting::first();

        if ($store->printer->type == 'online') {
            if ($settings->rest_api == null) {
                return response()->json([
                    'errors' => "Rest Api Not Found",
                    'message' => 'Silahkan Isi Rest Api Terlebih Dahulu'
                ]);
            }

            if ($store->printer->url == null) {
                return response()->json([
                    'errors' => "Url Not Found",
                    'message' => 'Silahkan Isi Url Printer Terlebih Dahulu'
                ]);
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $store->printer->url . "?app_url=http://" . $_SERVER['SERVER_NAME'] . '&id=' . $id . '&rest_key=' . $settings->rest_api . '&printer_connection=server',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
        } else {

            $connector = new WindowsPrintConnector($store->printer->name);
            $printer = new Printer($connector);

            $identity = $this->getPrintableHeader(
                'No: ' . $data->ref_no,
                'Jam: ' . $data->created_at
            );

            $subtotal = $this->getPrintableHeader(
                'Subtotal',
                number_format($data->total_before_tax)
            );

            $discount = $this->getPrintableHeader(
                'Diskon',
                number_format($data->discount_amount) . "%"
            );

            $tax = $this->getPrintableHeader(
                'Pajak',
                number_format($data->tax_amount) . "%"
            );

            $shipping = $this->getPrintableHeader(
                'Biaya Antar',
                number_format($data->shipping_charges)
            );

            $other = $this->getPrintableHeader(
                'Biaya Lainnya',
                number_format($data->other_charges)
            );

            $grandtotal = $this->getPrintableHeader(
                'Total',
                number_format($data->final_total)
            );

            $payment = $this->getPrintableHeader(
                'Pembayaran',
                $data->pay_total
            );

            $sell_callback = array();
            foreach ($data->sell as $sell) {
                $total = $sell->unit_price * $sell->qty;
                $list_sell = array(
                    'product_name'        => $sell->product->name . " - (" . $sell->variation->name . ")",
                    'qty' => $sell->qty,
                    'unit_price'  => $sell->unit_price,
                    'subtotal' => $total
                );
                array_push($sell_callback, $list_sell);
            }

            foreach ($sell_callback as $item) {
                $this->addItem(
                    $item['product_name'],
                    $item['qty'],
                    $item['unit_price'],
                    $item['subtotal']
                );
            }

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->feed(2);
            $printer->text($data->store->name . "\n");
            $printer->selectPrintMode();
            $printer->text($data->store->address . "\n");
            $printer->feed();
            $printer->selectPrintMode(1);
            $printer->text($identity . "\n");
            $printer->selectPrintMode(1);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($this->items as $item) {
                $printer->text($item);
            }
            $printer->feed();
            $printer->selectPrintMode();
            $printer->text($subtotal . "\n");
            $printer->text($discount . "\n");
            $printer->text($tax . "\n");
            $printer->text($shipping . "\n");
            $printer->text($other . "\n");
            $printer->text($grandtotal . "\n");
            $printer->text($payment . "\n");

            $printer->feed();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text($store->footer_text . "\n");
            $printer->cut();
            $printer->close();
        }
    }

    public function getPrintableHeader($left_text, $right_text, $is_double_width = false)
    {
        $cols_width = $is_double_width ? 8 : 16;

        return str_pad($left_text, $cols_width) . str_pad($right_text, $cols_width, ' ', STR_PAD_LEFT);
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function addItem($name, $qty, $price, $subtotal)
    {
        $item = new Item($name, $qty, $price, $subtotal);
        $item->setCurrency($this->currency);
        $this->items[] = $item;
    }
}
