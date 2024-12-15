<?php
 
use App\Models\Admin\Store;
use Illuminate\Support\Facades\Session; 

/**
 * Helper
 */

if (!function_exists('my_currency')) {

    function my_currency($price)
    {
        $data = Store::findOrFail(Session::get('mystore'));
        $symbol = $data->currency->symbol ?? '';
        if($data->currency_position == 1) {
            return $symbol .' '.number_format($price);
        } elseif($data->currency_position == 2) {
            return number_format($price) .' '. $symbol;
        } 
    }
 
}

if (!function_exists('my_date')) {

    function my_date($date)
    {
         return Timezone::convertToLocal($date,'d M, Y - H:i, ',true);
    }
 
}

