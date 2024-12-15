<?php

/**
 * Geo POS -  Accounting,  Invoicing  and CRM Software
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
} else {
    exit('Please set url in you pos app');
}
mb_internal_encoding("UTF-8");
require_once("vendor/autoload.php");
require_once("config.php");

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;

function getPrintableHeader($left_text, $right_text, $is_double_width = false)
{
    $cols_width = $is_double_width ? 8 : 16;

    return str_pad($left_text, $cols_width) . str_pad($right_text, $cols_width, ' ', STR_PAD_LEFT);
}


$curl = curl_init();
$url = $config['app_url'] . "/mdhpos/api/transaction/get-invoice/$id?restapi=" . $config['rest_key'];
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = json_decode(curl_exec($curl));

curl_close($curl);

// Return output
//  print_r($output['items']);
$connector = new WindowsPrintConnector($config['print_windows']);
$printer = new Printer($connector);

$identity = getPrintableHeader(
    'No: ' . $response->ref_no,
    'Jam: ' . $response->transaction_date
);

$subtotal = getPrintableHeader(
    'Subtotal',
    $response->subtotal
);

$discount = getPrintableHeader(
    'Diskon',
    $response->diskon
);

$tax = getPrintableHeader(
    'Pajak',
    $response->pajak
);

$shipping = getPrintableHeader(
    'Biaya Antar',
    $response->shipping
);

$other = getPrintableHeader(
    'Biaya Lainnya',
    $response->othercost
);

$grandtotal = getPrintableHeader(
    'Total',
    $response->total
);

$payment = getPrintableHeader(
    'Pembayaran',
    $response->paytotal
);


// $items[] = "";
// foreach ($item as $i) {
//     $items[] = $i;
// }
// echo $items;

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer->feed(2);
$printer->text($response->toko . "\n");
$printer->selectPrintMode();
$printer->text($response->alamat . "\n");
$printer->feed();
$printer->selectPrintMode(1);
$printer->text($identity . "\n");
$printer->selectPrintMode(1);
$printer->setJustification(Printer::JUSTIFY_LEFT);
// foreach (items as $item) {
//     $printer->text($item);
// }
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
$printer->text($response->footer . "\n");
$printer->cut();
$printer->close();
