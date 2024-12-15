<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Product\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StockController extends Controller
{
    public function stock_alert()
    {
        $data = Stock::where("store_id",Session::get('mystore'))->get();
        $product = array();
        foreach($data as $d) {
            //dd($d->product->alert_quantity);
            if($d->product->alert_quantity != "0") {
                if($d->product->alert_quantity >= $d->qty_available) {
                    if($d->variation->name != 'no-name') {
                        $name = $d->product->name .' - '. $d->variation->name;
                    } else {
                        $name = $d->product->name;
                    }
                    $list = [
                        'name'  => $name,
                        'stock' => $d->qty_available,
                        'image' => $d->variation->gambar->path ?? '/uploads/image.jpg',
                    ];
                    array_push($product,$list);
                }
            }
        }

        return view('admin.reports.stock.alert', ['page' => __('sidebar.stock_alert')], compact('product'));
    }
}
