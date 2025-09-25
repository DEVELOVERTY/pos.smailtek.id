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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

    /**
     * Get user data by barcode from Kedit system
     */
    public function getUserByBarcode(Request $request)
    {
        try {
            $barcode = $request->input('barcode');
            
            if (!$barcode) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Barcode is required'
                ], 400);
            }

            // Call Kedit API to get user data
            $keditBaseUrl = config('kedit.base_url');
            
            try {
                Log::info('Calling Kedit endpoint: ' . $keditBaseUrl . '/api/is-barcode-valid');
                
                $response = Http::timeout(10)->post($keditBaseUrl . '/api/is-barcode-valid', [
                    'barcode' => $barcode
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    Log::info('Success with Kedit API', $data);
                    
                    return response()->json([
                        'status' => 'success',
                        'data' => $data['data'] ?? null
                    ]);
                } else {
                    Log::error('Kedit API Error: ' . $response->status() . ' - ' . $response->body());
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to get user data from Kedit system: ' . $response->status()
                    ], 500);
                }
            } catch (\Exception $e) {
                Log::error('Kedit connection error: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cannot connect to Kedit system: ' . $e->getMessage()
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Get user by barcode error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Connection error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate user for transaction
     */
    public function validateUser(Request $request)
    {
        try {
            $userId = $request->input('id_user_card');
            
            if (!$userId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User ID is required'
                ], 400);
            }

            // Call Kedit API for validation
            $keditBaseUrl = config('kedit.base_url');
            
            // Get store token for validation
            $storeToken = $this->getCurrentStoreToken();
            
            if (!$storeToken) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Store token not configured'
                ], 400);
            }

            try {
                Log::info('Calling Kedit validation endpoint: ' . $keditBaseUrl . '/api/is-validasi');
                
                $response = Http::timeout(10)->post($keditBaseUrl . '/api/is-validasi', [
                    'id_user_card' => $userId,
                    'token_mart' => $storeToken
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    Log::info('Success with Kedit validation API', $data);
                    return $data;
                } else {
                    Log::error('Kedit validation API Error: ' . $response->status() . ' - ' . $response->body());
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to validate user: ' . $response->status()
                    ], 500);
                }
            } catch (\Exception $e) {
                Log::error('Kedit validation connection error: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cannot connect to Kedit validation system: ' . $e->getMessage()
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('User validation error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Connection error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current store token
     */
    private function getCurrentStoreToken()
    {
        $currentStoreId = session('mystore');
        
        if ($currentStoreId) {
            try {
                $storeToken = \App\Models\Admin\StoreToken::where('store_id', $currentStoreId)->first();
                return $storeToken ? $storeToken->token : null;
            } catch (\Exception $e) {
                Log::error('Error accessing store token: ' . $e->getMessage());
                return null;
            }
        }
        
        // Jika tidak ada store ID di session, coba ambil token pertama yang tersedia
        try {
            $storeToken = \App\Models\Admin\StoreToken::first();
            return $storeToken ? $storeToken->token : null;
        } catch (\Exception $e) {
            Log::error('Error accessing any store token: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Sync current store token with Kedit system
     */
    public function syncCurrentStoreToken()
    {
        try {
            $currentStoreId = session('mystore');
            
            if (!$currentStoreId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No store selected in session'
                ], 400);
            }

            $store = \App\Models\Admin\Store::findOrFail($currentStoreId);
            $storeToken = \App\Models\Admin\StoreToken::where('store_id', $currentStoreId)->first();
            
            if (!$storeToken) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No token found for current store. Please set token first in Token Toko menu.'
                ], 404);
            }

            // Sync dengan Kedit system
            $keditBaseUrl = config('kedit.base_url');
            $response = Http::timeout(10)->post($keditBaseUrl . '/api/merchant/sync-token', [
                'store_id' => $currentStoreId,
                'store_name' => $store->name,
                'token' => $storeToken->token,
                'sync_source' => 'pos_system'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Store token synced successfully with Kedit system',
                    'data' => [
                        'store_id' => $currentStoreId,
                        'store_name' => $store->name,
                        'token' => $storeToken->token,
                        'kedit_response' => $data
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to sync with Kedit: ' . $response->body(),
                    'status_code' => $response->status()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sync error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check current store token status
     */
    public function checkCurrentStoreTokenStatus()
    {
        try {
            $currentStoreId = session('mystore');
            
            if (!$currentStoreId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No store selected in session',
                    'has_token' => false,
                    'needs_setup' => true
                ]);
            }

            $store = \App\Models\Admin\Store::find($currentStoreId);
            if (!$store) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Store not found',
                    'has_token' => false,
                    'needs_setup' => true
                ]);
            }

            $storeToken = \App\Models\Admin\StoreToken::where('store_id', $currentStoreId)->first();
            
            $result = [
                'status' => 'success',
                'store_id' => $currentStoreId,
                'store_name' => $store->name,
                'has_token' => $storeToken ? true : false,
                'token' => $storeToken ? $storeToken->token : null,
                'needs_setup' => $storeToken ? false : true
            ];

            // Test koneksi ke Kedit jika ada token
            if ($storeToken) {
                try {
                    $keditBaseUrl = config('kedit.base_url');
                    $response = Http::timeout(5)->get($keditBaseUrl);
                    $result['kedit_connection'] = $response->successful() ? 'connected' : 'failed';
                    $result['kedit_status_code'] = $response->status();
                } catch (\Exception $e) {
                    $result['kedit_connection'] = 'failed';
                    $result['kedit_error'] = $e->getMessage();
                }
            }

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error checking token status: ' . $e->getMessage(),
                'has_token' => false,
                'needs_setup' => true
            ], 500);
        }
    }

    /**
     * Auto setup token for debugging - creates token if not exists
     */
    public function autoSetupTokenForDebugging()
    {
        try {
            $currentStoreId = session('mystore');
            
            if (!$currentStoreId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No store selected in session. Please login to a store first.'
                ], 400);
            }

            $store = \App\Models\Admin\Store::find($currentStoreId);
            if (!$store) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Store not found'
                ], 404);
            }

            // Check if token already exists
            $existingToken = \App\Models\Admin\StoreToken::where('store_id', $currentStoreId)->first();
            
            if ($existingToken) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Token already exists',
                    'data' => [
                        'store_id' => $currentStoreId,
                        'store_name' => $store->name,
                        'token' => $existingToken->token,
                        'created_at' => $existingToken->created_at
                    ]
                ]);
            }

            // Generate new token
            $attempts = 0;
            $maxAttempts = 100;
            
            do {
                $token = str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
                $attempts++;
                
                $tokenExists = \App\Models\Admin\StoreToken::where('token', $token)->exists();
                
                if ($attempts >= $maxAttempts) {
                    throw new \Exception('Cannot generate unique token after ' . $maxAttempts . ' attempts');
                }
                
            } while ($tokenExists);

            // Create token
            $storeToken = \App\Models\Admin\StoreToken::create([
                'store_id' => $currentStoreId,
                'token' => $token
            ]);

            // Auto sync with Kedit
            $syncResult = null;
            try {
                $keditBaseUrl = config('kedit.base_url');
                $response = Http::timeout(10)->post($keditBaseUrl . '/api/merchant/sync-token', [
                    'store_id' => $currentStoreId,
                    'store_name' => $store->name,
                    'token' => $token,
                    'sync_source' => 'pos_auto_setup'
                ]);

                if ($response->successful()) {
                    $syncResult = $response->json();
                }
            } catch (\Exception $e) {
                Log::warning('Auto sync to Kedit failed: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Token created and synced successfully',
                'data' => [
                    'store_id' => $currentStoreId,
                    'store_name' => $store->name,
                    'token' => $token,
                    'sync_result' => $syncResult,
                    'attempts' => $attempts
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Auto setup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Debug end-to-end payment process
     */
    public function debugPaymentProcess()
    {
        try {
            $results = [
                'step_1_token_check' => null,
                'step_2_kedit_connection' => null,
                'step_3_barcode_validation' => null,
                'step_4_user_validation' => null,
                'step_5_fingerprint_setup' => null,
                'recommendations' => []
            ];

            // Step 1: Check token
            $currentStoreId = session('mystore');
            if (!$currentStoreId) {
                $results['step_1_token_check'] = [
                    'status' => 'failed',
                    'message' => 'No store selected in session'
                ];
                $results['recommendations'][] = 'Please login to a store first';
            } else {
                $storeToken = \App\Models\Admin\StoreToken::where('store_id', $currentStoreId)->first();
                if (!$storeToken) {
                    $results['step_1_token_check'] = [
                        'status' => 'failed',
                        'message' => 'No token found for current store'
                    ];
                    $results['recommendations'][] = 'Run auto-setup-token-for-debugging endpoint';
                } else {
                    $results['step_1_token_check'] = [
                        'status' => 'success',
                        'token' => $storeToken->token,
                        'store_id' => $currentStoreId
                    ];
                }
            }

            // Step 2: Check Kedit connection
            try {
                $keditBaseUrl = config('kedit.base_url');
                $response = Http::timeout(5)->get($keditBaseUrl);
                if ($response->successful()) {
                    $results['step_2_kedit_connection'] = [
                        'status' => 'success',
                        'kedit_url' => $keditBaseUrl,
                        'response_code' => $response->status()
                    ];
                } else {
                    $results['step_2_kedit_connection'] = [
                        'status' => 'failed',
                        'kedit_url' => $keditBaseUrl,
                        'response_code' => $response->status()
                    ];
                    $results['recommendations'][] = 'Check if Kedit server is running at ' . $keditBaseUrl;
                }
            } catch (\Exception $e) {
                $results['step_2_kedit_connection'] = [
                    'status' => 'failed',
                    'error' => $e->getMessage()
                ];
                $results['recommendations'][] = 'Start Kedit server or check network connection';
            }

            // Step 3: Test barcode validation (if we have a test barcode)
            if (isset($results['step_1_token_check']['status']) && $results['step_1_token_check']['status'] === 'success') {
                try {
                    $testBarcode = '1234567890'; // Test barcode
                    $response = Http::timeout(10)->post($keditBaseUrl . '/api/is-barcode-valid', [
                        'barcode' => $testBarcode
                    ]);

                    $results['step_3_barcode_validation'] = [
                        'status' => $response->successful() ? 'success' : 'failed',
                        'test_barcode' => $testBarcode,
                        'response_code' => $response->status(),
                        'response_body' => $response->json()
                    ];

                    if (!$response->successful()) {
                        $results['recommendations'][] = 'Barcode validation endpoint not working. Check Kedit API routes.';
                    }
                } catch (\Exception $e) {
                    $results['step_3_barcode_validation'] = [
                        'status' => 'failed',
                        'error' => $e->getMessage()
                    ];
                }
            }

            // Step 4: Test user validation (if we have token and barcode works)
            if (isset($results['step_3_barcode_validation']['status']) && 
                $results['step_3_barcode_validation']['status'] === 'success' &&
                isset($results['step_1_token_check']['token'])) {
                
                try {
                    $testUserId = 1; // Test user ID
                    $token = $results['step_1_token_check']['token'];
                    
                    $response = Http::timeout(10)->post($keditBaseUrl . '/api/is-validasi', [
                        'id_user_card' => $testUserId,
                        'token_mart' => $token
                    ]);

                    $results['step_4_user_validation'] = [
                        'status' => $response->successful() ? 'success' : 'failed',
                        'test_user_id' => $testUserId,
                        'token_used' => $token,
                        'response_code' => $response->status(),
                        'response_body' => $response->json()
                    ];

                    if (!$response->successful()) {
                        $results['recommendations'][] = 'User validation failed. Check if token exists in Kedit merchants table.';
                    }
                } catch (\Exception $e) {
                    $results['step_4_user_validation'] = [
                        'status' => 'failed',
                        'error' => $e->getMessage()
                    ];
                }
            }

            // Step 5: Check fingerprint endpoints
            try {
                $testUserId = 1;
                $response = Http::timeout(10)->get($keditBaseUrl . '/api/user-card/' . $testUserId . '/fingerprint');
                
                $results['step_5_fingerprint_setup'] = [
                    'status' => $response->successful() ? 'success' : 'failed',
                    'test_user_id' => $testUserId,
                    'response_code' => $response->status(),
                    'has_fingerprint_data' => $response->successful() && !empty($response->json()['data'] ?? '')
                ];

                if (!$response->successful()) {
                    $results['recommendations'][] = 'Fingerprint endpoint not working. Check user data in Kedit.';
                }
            } catch (\Exception $e) {
                $results['step_5_fingerprint_setup'] = [
                    'status' => 'failed',
                    'error' => $e->getMessage()
                ];
            }

            // Overall assessment
            $successCount = 0;
            $totalSteps = 5;
            
            foreach (['step_1_token_check', 'step_2_kedit_connection', 'step_3_barcode_validation', 'step_4_user_validation', 'step_5_fingerprint_setup'] as $step) {
                if (isset($results[$step]['status']) && $results[$step]['status'] === 'success') {
                    $successCount++;
                }
            }

            $results['overall_status'] = [
                'success_rate' => round(($successCount / $totalSteps) * 100, 2) . '%',
                'successful_steps' => $successCount,
                'total_steps' => $totalSteps,
                'ready_for_payment' => $successCount >= 4
            ];

            if ($successCount < 4) {
                $results['recommendations'][] = 'Payment process not ready. Fix the failed steps above.';
            } else {
                $results['recommendations'][] = 'Payment process should work. Try making a payment with a valid barcode.';
            }

            return response()->json([
                'status' => 'success',
                'debug_results' => $results,
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Debug process failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate and sync tokens between POS and Kedit systems
     */
    public function validateTokenSync()
    {
        try {
            $keditBaseUrl = config('kedit.base_url');
            $results = [
                'pos_tokens' => [],
                'kedit_tokens' => [],
                'sync_status' => [],
                'recommendations' => []
            ];

            // 1. Get all tokens from POS system
            try {
                $posTokens = \App\Models\Admin\StoreToken::with('store')->get();
                foreach ($posTokens as $storeToken) {
                    $results['pos_tokens'][] = [
                        'store_id' => $storeToken->store_id,
                        'store_name' => $storeToken->store->name ?? 'Unknown',
                        'token' => $storeToken->token,
                        'created_at' => $storeToken->created_at
                    ];
                }
            } catch (\Exception $e) {
                $results['pos_tokens_error'] = 'Error accessing POS tokens: ' . $e->getMessage();
            }

            // 2. Get all tokens from Kedit system
            try {
                $response = Http::timeout(10)->get($keditBaseUrl . '/api/merchants/tokens');
                if ($response->successful()) {
                    $results['kedit_tokens'] = $response->json()['data'] ?? [];
                } else {
                    // Fallback: try to get merchants directly
                    $merchantResponse = Http::timeout(10)->get($keditBaseUrl . '/api/merchants');
                    if ($merchantResponse->successful()) {
                        $merchants = $merchantResponse->json()['data'] ?? [];
                        foreach ($merchants as $merchant) {
                            if (!empty($merchant['token'])) {
                                $results['kedit_tokens'][] = [
                                    'merchant_id' => $merchant['id'],
                                    'merchant_name' => $merchant['nama_merchant'],
                                    'token' => $merchant['token'],
                                    'aktif_limit' => $merchant['aktif_limit'] ?? 'N'
                                ];
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                $results['kedit_tokens_error'] = 'Error accessing Kedit tokens: ' . $e->getMessage();
            }

            // 3. Compare and analyze tokens
            $posTokensList = collect($results['pos_tokens'])->pluck('token')->toArray();
            $keditTokensList = collect($results['kedit_tokens'])->pluck('token')->toArray();

            // Tokens that exist in POS but not in Kedit
            $posOnlyTokens = array_diff($posTokensList, $keditTokensList);
            // Tokens that exist in Kedit but not in POS
            $keditOnlyTokens = array_diff($keditTokensList, $posTokensList);
            // Tokens that exist in both systems
            $commonTokens = array_intersect($posTokensList, $keditTokensList);

            $results['sync_status'] = [
                'pos_only_tokens' => $posOnlyTokens,
                'kedit_only_tokens' => $keditOnlyTokens,
                'common_tokens' => $commonTokens,
                'total_pos_tokens' => count($posTokensList),
                'total_kedit_tokens' => count($keditTokensList),
                'sync_percentage' => count($posTokensList) > 0 ? 
                    round((count($commonTokens) / count($posTokensList)) * 100, 2) : 0
            ];

            // 4. Generate recommendations
            if (!empty($posOnlyTokens)) {
                $results['recommendations'][] = [
                    'type' => 'sync_to_kedit',
                    'message' => 'Ada ' . count($posOnlyTokens) . ' token di POS yang belum ada di Kedit',
                    'tokens' => $posOnlyTokens,
                    'action' => 'Sinkronisasi token dari POS ke Kedit'
                ];
            }

            if (!empty($keditOnlyTokens)) {
                $results['recommendations'][] = [
                    'type' => 'sync_to_pos',
                    'message' => 'Ada ' . count($keditOnlyTokens) . ' token di Kedit yang belum ada di POS',
                    'tokens' => $keditOnlyTokens,
                    'action' => 'Tambahkan token ke POS atau hapus dari Kedit'
                ];
            }

            if (empty($commonTokens) && !empty($posTokensList)) {
                $results['recommendations'][] = [
                    'type' => 'no_sync',
                    'message' => 'Tidak ada token yang tersinkronisasi antara POS dan Kedit',
                    'action' => 'Lakukan sinkronisasi penuh'
                ];
            }

            return response()->json([
                'status' => 'success',
                'data' => $results,
                'summary' => [
                    'pos_tokens_count' => count($posTokensList),
                    'kedit_tokens_count' => count($keditTokensList),
                    'synced_tokens_count' => count($commonTokens),
                    'sync_percentage' => $results['sync_status']['sync_percentage']
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token validation error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test connection to Kedit system and list available endpoints
     */
    public function testKeditConnection()
    {
        $keditBaseUrl = config('kedit.base_url');
        
        try {
            // Test basic connection
            $response = Http::timeout(5)->get($keditBaseUrl);
            
            $result = [
                'kedit_base_url' => $keditBaseUrl,
                'connection_status' => $response->successful() ? 'success' : 'failed',
                'status_code' => $response->status(),
                'tested_endpoints' => []
            ];

            // Test common endpoints
            $testEndpoints = [
                '/api/get-user-by-barcode',
                '/api/user-card/get-by-barcode',
                '/api/user/get-by-barcode', 
                '/api/get-user-card-by-barcode',
                '/api/is-validasi',
                '/api/user-card/is-validasi',
                '/api/user/validate',
                '/api/validate-user'
            ];

            foreach ($testEndpoints as $endpoint) {
                try {
                    $testResponse = Http::timeout(3)->post($keditBaseUrl . $endpoint, [
                        'test' => true
                    ]);
                    
                    $result['tested_endpoints'][$endpoint] = [
                        'status' => $testResponse->status(),
                        'available' => $testResponse->status() !== 404
                    ];
                } catch (\Exception $e) {
                    $result['tested_endpoints'][$endpoint] = [
                        'status' => 'error',
                        'error' => $e->getMessage(),
                        'available' => false
                    ];
                }
            }

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'kedit_base_url' => $keditBaseUrl,
                'connection_status' => 'failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
