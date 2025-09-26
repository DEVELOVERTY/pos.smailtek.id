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
     * Get user data by barcode from Sidik system
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

            // Call Sidik API to get user data
            $keditBaseUrl = config('kedit.base_url');
            
            try {
                Log::info('Calling Sidik endpoint: ' . $keditBaseUrl . '/api/is-barcode-valid');
                
                $response = Http::timeout(10)->post($keditBaseUrl . '/api/is-barcode-valid', [
                    'barcode' => $barcode
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    Log::info('Success with Sidik API', $data);
                    
                    return response()->json([
                        'status' => 'success',
                        'data' => $data['data'] ?? null
                    ]);
                } else {
                    Log::error('Sidik API Error: ' . $response->status() . ' - ' . $response->body());
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to get user data from Sidik system: ' . $response->status()
                    ], 500);
                }
            } catch (\Exception $e) {
                Log::error('Sidik connection error: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cannot connect to Sidik system: ' . $e->getMessage()
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
     * Validate barcode for SIDIK transactions
     */
    public function validateBarcodeForSidik($barcode)
    {
        try {
            if (!$barcode) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Barcode is required'
                ], 400);
            }

            // Get store token
            $storeToken = $this->getCurrentStoreToken();
            
            if (!$storeToken) {
                Log::warning('Store token not found for barcode validation', [
                    'barcode' => $barcode,
                    'store_id' => session('mystore'),
                    'session_id' => session()->getId()
                ]);
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Store token not configured',
                    'error_type' => 'token_not_found',
                    'data' => false,
                    'instructions' => 'Silakan hubungi admin untuk mengatur token toko di menu Token Toko'
                ], 400);
            }

            // Call Sidik API to validate barcode
            $keditBaseUrl = config('kedit.base_url');
            
            try {
                Log::info('Validating barcode with Sidik: ' . $keditBaseUrl . '/api/is-barcode-valid', [
                    'barcode' => $barcode,
                    'store_token' => $storeToken
                ]);
                
                $response = Http::timeout(15)->post($keditBaseUrl . '/api/is-barcode-valid', [
                    'barcode' => $barcode,
                    'token_mart' => $storeToken
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    Log::info('Barcode validation response from Sidik', $data);
                    
                    // Check if barcode is valid
                    if (isset($data['status']) && $data['status'] === 'success' && 
                        isset($data['data']) && $data['data'] !== null) {
                        
                        return response()->json([
                            'status' => 'success',
                            'data' => true,
                            'message' => 'Barcode valid'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'data' => false,
                            'message' => 'Barcode tidak valid atau tidak terdaftar'
                        ]);
                    }
                } else {
                    Log::error('Sidik barcode validation failed', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'barcode' => $barcode
                    ]);
                    
                    return response()->json([
                        'status' => 'error',
                        'data' => false,
                        'message' => 'Gagal validasi barcode: ' . $response->status()
                    ], 500);
                }
            } catch (\Exception $e) {
                Log::error('Sidik connection error during barcode validation', [
                    'error' => $e->getMessage(),
                    'barcode' => $barcode
                ]);
                
                return response()->json([
                    'status' => 'error',
                    'data' => false,
                    'message' => 'Tidak dapat terhubung ke sistem Sidik: ' . $e->getMessage()
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Barcode validation error', [
                'error' => $e->getMessage(),
                'barcode' => $barcode
            ]);
            
            return response()->json([
                'status' => 'error',
                'data' => false,
                'message' => 'Error validasi barcode: ' . $e->getMessage()
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

            // Call Sidik API for validation
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
                // Test connection to Sidik server first
                Log::info('Testing connection to Sidik server', [
                    'base_url' => $keditBaseUrl
                ]);
                
                $testResponse = Http::timeout(5)->get($keditBaseUrl);
                if (!$testResponse->successful()) {
                    Log::warning('Sidik server connection test failed', [
                        'status' => $testResponse->status(),
                        'url' => $keditBaseUrl
                    ]);
                }
                
                Log::info('Calling Sidik validation endpoint', [
                    'url' => $keditBaseUrl . '/api/is-validasi',
                    'user_id' => $userId,
                    'token' => substr($storeToken, 0, 10) . '...' // Log partial token for security
                ]);
                
                $response = Http::timeout(15)->post($keditBaseUrl . '/api/is-validasi', [
                    'id_user_card' => $userId,
                    'token_mart' => $storeToken
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    Log::info('Success with Sidik validation API', $data);
                    
                    // Check if the response indicates token validation success
                    if (!isset($data['status']) || $data['status'] !== 'success') {
                        Log::error('Sidik API returned non-success status', [
                            'response' => $data,
                            'token' => $storeToken
                        ]);
                        
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Token validation failed: ' . ($data['message'] ?? 'Invalid response from Sidik'),
                            'token_validation_failed' => true
                        ], 400);
                    }
                    
                    // Get merchant limit settings to determine if limit checking should be applied
                    $merchantLimitActive = 'Y'; // Default to active (safe default)
                    try {
                        // Try to get merchant data from the validation response first
                        if (isset($data['data']['merchant']) && isset($data['data']['merchant']['aktif_limit'])) {
                            $merchantLimitActive = $data['data']['merchant']['aktif_limit'];
                            Log::info('Merchant limit setting from validation response', [
                                'limit_active' => $merchantLimitActive
                            ]);
                        } else {
                            // Fallback: try separate merchant endpoint (might not exist)
                            try {
                                $merchantResponse = Http::timeout(5)->post($keditBaseUrl . '/api/get-merchant-by-token', [
                                    'token_mart' => $storeToken
                                ]);
                                
                                if ($merchantResponse->successful()) {
                                    $merchantData = $merchantResponse->json();
                                    if (isset($merchantData['data']['aktif_limit'])) {
                                        $merchantLimitActive = $merchantData['data']['aktif_limit'];
                                        Log::info('Merchant limit setting from separate endpoint', [
                                            'merchant_id' => $merchantData['data']['id'] ?? null,
                                            'merchant_name' => $merchantData['data']['nama_merchant'] ?? null,
                                            'limit_active' => $merchantLimitActive
                                        ]);
                                    }
                                } else if ($merchantResponse->status() === 404) {
                                    Log::info('Merchant endpoint not available, using default limit setting');
                                }
                            } catch (\Exception $merchantException) {
                                Log::info('Merchant endpoint not accessible, using default limit setting', [
                                    'error' => $merchantException->getMessage()
                                ]);
                            }
                        }
                    } catch (\Exception $e) {
                        Log::warning('Error processing merchant limit settings, using default', [
                            'error' => $e->getMessage()
                        ]);
                    }
                    
                    // Add merchant limit setting and token validation info to response
                    if (isset($data['data'])) {
                        $data['data']['merchant_limit_active'] = $merchantLimitActive;
                        $data['data']['token_validated'] = true;
                        $data['data']['token_validation_method'] = 'integrated_is_validasi';
                        
                        // If merchant limit is not active, override limit-related restrictions
                        if ($merchantLimitActive === 'N') {
                            Log::info('Merchant limit is disabled, allowing transaction regardless of user limit');
                            $data['data']['limit_override'] = true;
                            $data['data']['limit_override_reason'] = 'Merchant limit disabled';
                            
                            // Override limit-related fields to allow transaction
                            if (isset($data['data']['sisa_limit']) && $data['data']['sisa_limit'] <= 0) {
                                $data['data']['sisa_limit'] = 999999999; // Set to high value to bypass limit check
                                $data['data']['original_sisa_limit'] = $data['data']['sisa_limit']; // Keep original for reference
                            }
                        }
                    }
                    
                    return $data;
                } else {
                    Log::error('Sidik validation API Error', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'url' => $keditBaseUrl . '/api/is-validasi',
                        'user_id' => $userId,
                        'headers' => $response->headers()
                    ]);
                    
                    // Return more specific error based on HTTP status
                    $errorMessage = 'Server error. Hubungi admin sistem.';
                    if ($response->status() == 404) {
                        $errorMessage = 'Endpoint validasi tidak ditemukan.';
                    } elseif ($response->status() == 401 || $response->status() == 403) {
                        $errorMessage = 'Token tidak valid atau akses ditolak.';
                    } elseif ($response->status() == 422) {
                        $errorMessage = 'Data tidak valid untuk validasi.';
                    }
                    
                    return response()->json([
                        'status' => 'error',
                        'message' => $errorMessage
                    ], 500);
                }
            } catch (\Exception $e) {
                Log::error('Sidik validation connection error', [
                    'error' => $e->getMessage(),
                    'url' => $keditBaseUrl . '/api/is-validasi',
                    'user_id' => $userId,
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Check if it's a specific connection issue
                $errorMessage = 'Server error. Hubungi admin sistem.';
                if (strpos($e->getMessage(), 'timeout') !== false) {
                    $errorMessage = 'Koneksi timeout ke server Sidik. Coba lagi.';
                } elseif (strpos($e->getMessage(), 'Connection refused') !== false) {
                    $errorMessage = 'Server Sidik tidak dapat diakses.';
                } elseif (strpos($e->getMessage(), 'Could not resolve host') !== false) {
                    $errorMessage = 'Server Sidik tidak ditemukan.';
                } elseif (strpos($e->getMessage(), 'SSL') !== false) {
                    $errorMessage = 'Error SSL koneksi ke server Sidik.';
                }
                
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage
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
     * Test connection to Sidik server with comprehensive endpoint testing
     */
    public function testSidikConnection()
    {
        $keditBaseUrl = config('kedit.base_url');
        
        try {
            Log::info('Testing Sidik server connection', ['url' => $keditBaseUrl]);
            
            $result = [
                'environment' => strpos($keditBaseUrl, 'localhost') !== false || strpos($keditBaseUrl, '127.0.0.1') !== false ? 'local' : 'sandbox',
                'base_url' => $keditBaseUrl,
                'ssl_enabled' => strpos($keditBaseUrl, 'https') === 0,
                'connection_test' => null,
                'endpoints_test' => [],
                'recommendations' => []
            ];
            
            // Test basic connection with more details
            try {
                $startTime = microtime(true);
                $response = Http::timeout(10)->get($keditBaseUrl);
                $responseTime = round((microtime(true) - $startTime) * 1000, 2);
                
                $result['connection_test'] = [
                    'status' => $response->successful() ? 'success' : 'failed',
                    'http_status' => $response->status(),
                    'response_time_ms' => $responseTime,
                    'headers' => $response->headers(),
                    'body_preview' => substr($response->body(), 0, 200)
                ];
                
                if (!$response->successful()) {
                    $result['recommendations'][] = 'Basic connection failed. Check if Sidik server is running at ' . $keditBaseUrl;
                }
            } catch (\Exception $e) {
                $result['connection_test'] = [
                    'status' => 'error',
                    'error' => $e->getMessage(),
                    'error_type' => get_class($e)
                ];
                $result['recommendations'][] = 'Connection error: ' . $e->getMessage();
            }
            
            // Test critical endpoints used in the application
            $criticalEndpoints = [
                '/api/is-validasi' => ['id_user_card' => 1, 'token_mart' => 'test'],
                '/api/is-barcode-valid' => ['barcode' => 'test123'],
                '/api/get-merchant-by-token' => ['token_mart' => 'test'],
                '/api/validate-merchant-token' => ['token_mart' => 'test'],
                '/api/merchant/sync-token' => ['token' => 'test', 'store_id' => 1]
            ];
            
            foreach ($criticalEndpoints as $endpoint => $testData) {
                try {
                    $startTime = microtime(true);
                    $testResponse = Http::timeout(5)->post($keditBaseUrl . $endpoint, $testData);
                    $responseTime = round((microtime(true) - $startTime) * 1000, 2);
                    
                    $result['endpoints_test'][$endpoint] = [
                        'status' => $testResponse->status(),
                        'available' => $testResponse->status() != 404,
                        'response_time_ms' => $responseTime,
                        'response_preview' => substr($testResponse->body(), 0, 200),
                        'test_data' => $testData
                    ];
                    
                    // Add specific recommendations
                    if ($testResponse->status() == 404) {
                        $result['recommendations'][] = "Endpoint {$endpoint} not found (404). This endpoint is used in the application.";
                    } elseif ($testResponse->status() >= 500) {
                        $result['recommendations'][] = "Endpoint {$endpoint} has server error ({$testResponse->status()}).";
                    }
                    
                } catch (\Exception $e) {
                    $result['endpoints_test'][$endpoint] = [
                        'status' => 'error',
                        'available' => false,
                        'error' => $e->getMessage(),
                        'test_data' => $testData
                    ];
                }
            }
            
            // Environment-specific recommendations
            if ($result['environment'] === 'sandbox') {
                $result['recommendations'][] = 'Testing sandbox environment. Ensure all endpoints are deployed and SSL certificates are valid.';
                
                if ($result['ssl_enabled'] && isset($result['connection_test']['status']) && $result['connection_test']['status'] === 'error') {
                    $result['recommendations'][] = 'SSL connection issue detected. Check SSL certificate validity.';
                }
            } else {
                $result['recommendations'][] = 'Testing local environment. Ensure Sidik server is running locally.';
            }
            
            // Summary
            $availableEndpoints = 0;
            $totalEndpoints = count($criticalEndpoints);
            
            foreach ($result['endpoints_test'] as $endpoint => $data) {
                if (isset($data['available']) && $data['available']) {
                    $availableEndpoints++;
                }
            }
            
            $result['summary'] = [
                'environment' => $result['environment'],
                'connection_ok' => isset($result['connection_test']['status']) && $result['connection_test']['status'] === 'success',
                'available_endpoints' => $availableEndpoints,
                'total_endpoints' => $totalEndpoints,
                'endpoint_availability' => round(($availableEndpoints / $totalEndpoints) * 100, 2) . '%',
                'ready_for_transactions' => $availableEndpoints >= 2 // At least is-validasi and is-barcode-valid
            ];
            
            Log::info('Sidik connection test completed', $result['summary']);
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            $result = [
                'status' => 'error',
                'url' => $keditBaseUrl,
                'message' => 'Connection test failed: ' . $e->getMessage(),
                'error_type' => get_class($e)
            ];
            
            Log::error('Sidik connection test failed', $result);
            
            return response()->json($result, 500);
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
     * Sync current store token with Sidik system
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

            // Sync dengan Sidik system
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
                    'message' => 'Store token synced successfully with Sidik system',
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
                    'message' => 'Failed to sync with Sidik: ' . $response->body(),
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
     * Strict token validation with Sidik system
     */
    public function validateTokenWithSidik()
    {
        try {
            $currentStoreId = session('mystore');
            
            if (!$currentStoreId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No store selected in session',
                    'token_valid' => false,
                    'validation_error' => 'Store session tidak ditemukan'
                ]);
            }

            $store = \App\Models\Admin\Store::find($currentStoreId);
            if (!$store) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Store not found',
                    'token_valid' => false,
                    'validation_error' => 'Store tidak ditemukan'
                ]);
            }

            $storeToken = \App\Models\Admin\StoreToken::where('store_id', $currentStoreId)->first();
            
            if (!$storeToken) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Store token not configured',
                    'token_valid' => false,
                    'validation_error' => 'Token toko belum dikonfigurasi'
                ]);
            }

            $keditBaseUrl = config('kedit.base_url');
            
            // Test connection first
            try {
                $connectionResponse = Http::timeout(5)->get($keditBaseUrl);
                if (!$connectionResponse->successful()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Cannot connect to Sidik system',
                        'token_valid' => false,
                        'validation_error' => 'Tidak dapat terhubung ke sistem Sidik'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sidik connection failed: ' . $e->getMessage(),
                    'token_valid' => false,
                    'validation_error' => 'Koneksi ke Sidik gagal: ' . $e->getMessage()
                ]);
            }

            // Validate token using is-validasi endpoint (most reliable)
            try {
                Log::info('Strict token validation with Sidik', [
                    'token' => $storeToken->token,
                    'store_id' => $currentStoreId,
                    'endpoint' => '/api/is-validasi'
                ]);

                $validationResponse = Http::timeout(15)->post($keditBaseUrl . '/api/is-validasi', [
                    'id_user_card' => 1, // Test user for token validation
                    'token_mart' => $storeToken->token
                ]);

                if ($validationResponse->successful()) {
                    $validationData = $validationResponse->json();
                    Log::info('Sidik token validation response', $validationData);

                    if (isset($validationData['status']) && $validationData['status'] === 'success') {
                        // Token is valid - extract merchant information
                        $result = [
                            'status' => 'success',
                            'token_valid' => true,
                            'validation_method' => 'sidik_is_validasi',
                            'store_id' => $currentStoreId,
                            'store_name' => $store->name,
                            'token' => $storeToken->token
                        ];

                        // Extract merchant limit settings if available
                        if (isset($validationData['data']['merchant'])) {
                            $merchantData = $validationData['data']['merchant'];
                            $result['merchant_limit_active'] = $merchantData['aktif_limit'] ?? 'Y';
                            $result['merchant_name'] = $merchantData['nama_merchant'] ?? $store->name;
                            $result['merchant_id'] = $merchantData['id'] ?? $currentStoreId;
                        } else {
                            // Default merchant settings
                            $result['merchant_limit_active'] = 'Y';
                            $result['merchant_name'] = $store->name;
                            $result['merchant_id'] = $currentStoreId;
                        }

                        Log::info('Token validation successful', [
                            'token' => $storeToken->token,
                            'merchant_limit_active' => $result['merchant_limit_active'],
                            'validation_method' => 'sidik_is_validasi'
                        ]);

                        return response()->json($result);
                    } else {
                        // Token validation failed
                        Log::error('Token validation failed - invalid token', [
                            'token' => $storeToken->token,
                            'response' => $validationData
                        ]);

                        return response()->json([
                            'status' => 'error',
                            'token_valid' => false,
                            'validation_error' => $validationData['message'] ?? 'Token tidak valid di sistem Sidik',
                            'sidik_response' => $validationData
                        ]);
                    }
                } else {
                    // API call failed
                    Log::error('Token validation API call failed', [
                        'status' => $validationResponse->status(),
                        'body' => $validationResponse->body(),
                        'token' => $storeToken->token
                    ]);

                    return response()->json([
                        'status' => 'error',
                        'token_valid' => false,
                        'validation_error' => 'Gagal memanggil API validasi Sidik: HTTP ' . $validationResponse->status()
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Token validation exception', [
                    'error' => $e->getMessage(),
                    'token' => $storeToken->token
                ]);

                return response()->json([
                    'status' => 'error',
                    'token_valid' => false,
                    'validation_error' => 'Error validasi token: ' . $e->getMessage()
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Strict token validation error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'token_valid' => false,
                'validation_error' => 'System error: ' . $e->getMessage()
            ]);
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

            // Test koneksi dan validasi token dengan Kedit jika ada token
            if ($storeToken) {
                try {
                    $keditBaseUrl = config('kedit.base_url');
                    
                    // First test basic connection
                    $connectionResponse = Http::timeout(5)->get($keditBaseUrl);
                    $result['kedit_connection'] = $connectionResponse->successful() ? 'connected' : 'failed';
                    $result['kedit_status_code'] = $connectionResponse->status();
                    
                    // If connection successful, validate token with Kedit
                    if ($connectionResponse->successful()) {
                        Log::info('Validating token with Kedit system', [
                            'token' => $storeToken->token,
                            'store_id' => $currentStoreId
                        ]);
                        
                        // Test token validity by calling Kedit validation endpoint
                        // First try the dedicated merchant token validation endpoint
                        $tokenValidationResponse = Http::timeout(10)->post($keditBaseUrl . '/api/validate-merchant-token', [
                            'token_mart' => $storeToken->token,
                            'store_id' => $currentStoreId,
                            'store_name' => $store->name
                        ]);
                        
                        // If that doesn't exist, try using the is-validasi endpoint with a test user
                        if ($tokenValidationResponse->status() === 404) {
                            Log::info('Primary merchant validation endpoint not found, trying is-validasi endpoint for token validation');
                            
                            $tokenValidationResponse = Http::timeout(10)->post($keditBaseUrl . '/api/is-validasi', [
                                'id_user_card' => 1, // Use test user ID to validate token
                                'token_mart' => $storeToken->token
                            ]);
                        }
                        
                        if ($tokenValidationResponse->successful()) {
                            $validationData = $tokenValidationResponse->json();
                            Log::info('Token validation response from Kedit', $validationData);
                            
                            // Check if token is actually valid in Kedit system
                            // For validate-merchant-token endpoint
                            if (isset($validationData['status']) && $validationData['status'] === 'success' && 
                                isset($validationData['valid']) && $validationData['valid'] === true) {
                                
                                $result['token_valid'] = true;
                                $result['token_validation'] = 'success';
                                $result['kedit_merchant_data'] = $validationData['data'] ?? null;
                            }
                            // For is-validasi endpoint (fallback validation)
                            else if (isset($validationData['status']) && $validationData['status'] === 'success') {
                                // If is-validasi returns success, it means token is valid
                                $result['token_valid'] = true;
                                $result['token_validation'] = 'success_fallback';
                                $result['kedit_merchant_data'] = $validationData['data'] ?? null;
                                
                                Log::info('Token validated using is-validasi endpoint', [
                                    'validation_method' => 'is_validasi_fallback',
                                    'token' => $storeToken->token
                                ]);
                                
                                // Extract merchant limit settings
                                if (isset($validationData['data']['merchant'])) {
                                    $merchantData = $validationData['data']['merchant'];
                                    $result['merchant_limit_active'] = $merchantData['aktif_limit'] ?? 'N';
                                    $result['merchant_name'] = $merchantData['nama_merchant'] ?? null;
                                    $result['merchant_id'] = $merchantData['id'] ?? null;
                                    
                                    Log::info('Merchant limit settings retrieved', [
                                        'merchant_id' => $result['merchant_id'],
                                        'merchant_name' => $result['merchant_name'],
                                        'limit_active' => $result['merchant_limit_active'],
                                        'token' => $storeToken->token
                                    ]);
                                } else {
                                    // Default to limit active if merchant data not available
                                    $result['merchant_limit_active'] = 'Y';
                                    Log::warning('Merchant data not found in validation response, defaulting to limit active');
                                }
                            } else {
                                $result['token_valid'] = false;
                                $result['token_validation'] = 'invalid';
                                $result['validation_error'] = $validationData['message'] ?? 'Token tidak valid di sistem Kedit';
                                $result['needs_setup'] = true; // Force setup if token invalid
                            }
                        } else if ($tokenValidationResponse->status() === 404) {
                            // Primary endpoint not found - this is a critical error for token validation
                            Log::error('Token validation endpoint not found in Kedit system', [
                                'endpoint' => '/api/validate-merchant-token',
                                'kedit_url' => $keditBaseUrl,
                                'token' => $storeToken->token,
                                'store_id' => $currentStoreId
                            ]);
                            
                            $result['token_valid'] = false;
                            $result['token_validation'] = 'endpoint_not_found';
                            $result['validation_error'] = 'Endpoint validasi token tidak ditemukan di sistem Kedit. Token tidak dapat divalidasi.';
                            $result['needs_setup'] = true;
                        } else {
                            // Token validation endpoint failed
                            Log::error('Token validation failed', [
                                'status' => $tokenValidationResponse->status(),
                                'body' => $tokenValidationResponse->body()
                            ]);
                            
                            $result['token_valid'] = false;
                            $result['token_validation'] = 'failed';
                            $result['validation_error'] = 'Gagal memvalidasi token dengan sistem Kedit: ' . $tokenValidationResponse->status();
                        }
                    } else {
                        $result['token_valid'] = false;
                        $result['token_validation'] = 'connection_failed';
                        $result['validation_error'] = 'Tidak dapat terhubung ke sistem Kedit';
                    }
                    
                } catch (\Exception $e) {
                    Log::error('Token validation error', [
                        'error' => $e->getMessage(),
                        'token' => $storeToken->token
                    ]);
                    
                    $result['kedit_connection'] = 'failed';
                    $result['kedit_error'] = $e->getMessage();
                    $result['token_valid'] = false;
                    $result['token_validation'] = 'error';
                    $result['validation_error'] = 'Error validasi token: ' . $e->getMessage();
                }
            } else {
                $result['token_valid'] = false;
                $result['token_validation'] = 'no_token';
                $result['validation_error'] = 'Token tidak ditemukan';
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
