<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Setting;
use App\Models\Admin\Store;
use App\Models\Transaction\Transaction;
use charlieuki\ReceiptPrinter\Item as Item;
use Illuminate\Http\Request;

class RestController extends Controller
{

    private $items;
    private $currency = 'Rp';

    public function getInvoice($invoiceId, Request $request )
    {

        $getRest = Setting::first();
        if($getRest->rest_api == null ) {
            return response()->json([
                'errors' => "notfound",
                'message' => 'No Rest Api'
            ]);
        }

        if($getRest->rest_api != $request->restapi) {
            return response()->json([
                'errors' => "notfound",
                'message' => 'Rest Api Tidak Valid'
            ]);
        }

        $getInvoice = Transaction::where("id",$invoiceId)->first();
        if($getInvoice == null) {
            return response()->json([
                'errors' => "transaction-notfound",
                'message' => 'Maaf, Transaksi untuk id '. $invoiceId . ' Tidak kami temukan'
            ]);
        }

        $sell_callback = array();
        foreach ($getInvoice->sell as $sell) {
            $total = $sell->unit_price * $sell->qty;
            $list_sell = array(
                'product_name'        => $sell->product->name . " - (" . $sell->variation->name . ")",
                'qty' => $sell->qty,
                'unit_price'  => $sell->unit_price,
                'subtotal' => $total
            );
            array_push($sell_callback, $list_sell);
        }

        
        return response()->json([
            'toko'  => $getInvoice->store->name,
            'alamat'    => $getInvoice->store->address,
            'footer'    => $getInvoice->store->footer_text,
            'transaction_date' => \Timezone::convertToLocal($getInvoice->created_at,'d M, Y - H:i, '),
            'ref_no' => $getInvoice->ref_no,
            'subtotal'  => number_format($getInvoice->total_before_tax),
            'diskon'    => number_format($getInvoice->discount_amount) . '%',
            'pajak'     => number_format($getInvoice->tax_amount)."%",
            'shipping'  => number_format($getInvoice->shipping_charges),
            'othercost' => number_format($getInvoice->other_charges),
            'total'     => number_format($getInvoice->final_total),
            'paytotal'  => $getInvoice->pay_total,
            'item'      => $sell_callback
        ]);
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function addItem($name, $qty, $price, $subtotal)
    {
        $item = new Item($name, $qty, $price, $subtotal); 
        $item->setCurrency($this->currency);
        $this->items[] = $item; 
    }

    public function printInvoice($id,$store)
    {

        $data = Transaction::findOrFail($id); 
        $store = Store::findOrFail($store);
        $settings = Setting::first();

        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $store->printer->url . "?app_url=http://" . $_SERVER['SERVER_NAME'] . '&id=' . $id . '&rest_key=' . $settings->rest_api . '&printer_connection=server');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.66 Safari/537.36");
        // Decode returned JSON
        $output = json_decode(curl_exec($ch), true);
        // Close Channel
        dd($output);
        curl_close($ch);
    }
}
