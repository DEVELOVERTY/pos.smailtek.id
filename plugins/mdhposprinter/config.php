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
/*
|--------------------------------------------------------------------------
| Local Thermal PrinterConfig
|--------------------------------------------------------------------------
|
*/

//GeoPOS Application URL with slash eg. http://example.com/pos/';
// with slash

$config['app_url'] = 'http://localhost/';


/*
 |--------------------------------------------------------------------------------------------------
REST API KEY
You can generate REST API KEY in your geo pos application>settings>REST API
*/
$config['rest_key'] = 'Q79PEZADC3TJ';
/*

 |--------------------------------------------------------------------------------------------------
Printer Connection

To print receipts from PHP, use the most applicable PrintConnector for
 your setup. The connector simply provides the plumbing to get data to the printer.
Values =>
For FilePrintConnector =  'file'
NetworkPrintConnector = 'network'
WindowsPrintConnector (USB) = 'windows'
DummyPrintConnector = 'test'
|--------------------------------------------------------------------------------------------------
 */
$config['printer_connection'] = 'windows';

/*
  |   Connector Value

For Windows // Enter the share name for your USB/LPT1 printer here

For Network

/* Most printers are open on port 9100, so you just need to know the IP
 * address of your receipt printer, and then fsockopen() it on that port.
 */
//
//Applicable only for For FilePrintConnector
$config['print_file'] = '/dev/usb/lp0';

//Applicable only for For NetworkPrintConnector
$config['print_network'] = array("10.x.x.x", 9100);

//Applicable only for For windows
$config['print_windows'] = 'kasir printer';


//DO NOT EDIT

if(isset($_REQUEST['app_url'])) $config['app_url']=$_REQUEST['app_url'];
if(isset($_REQUEST['rest_key'])) $config['rest_key']=$_REQUEST['rest_key'];
//if(isset($_REQUEST['printer_connection'])) $config['printer_connection']=$_REQUEST['rest_key'];