<?php

namespace App\Http\Controllers\Api\Sidik;

use App\Http\Controllers\Controller;
use App\Models\LogFinger;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function verifyFingerprint($userId, $transactionCode)
    {
        $time_limit_ver = 15;
        $res = Http::withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json, text-plain, */*",
            "X-Requested-With" => "XMLHttpRequest",
        ])
            ->get('https://admin.sidikty.com/api/user-card/' . $userId . '/fingerprint')
            ->json();
        echo $userId . "," . $transactionCode .';' . $res['data'] . ";SecurityKey;" . $time_limit_ver . ";" . route('user.process-verify-fingerprint') . ";" . "https://admin.sidikty.com/api/device-ac-sn-by-vc;extraParams";

    }

    public function processVerifyFingerprint()
    {
        $data = explode(";", $_POST['VerPas']);
        $userId = explode(',', $data[0])[0];
        $transactionCode = explode(',', $data[0])[1];
        $vStamp = $data[1];
        $time = $data[2];
        $sn = $data[3];

        $res = Http::withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json, text-plain, */*",
            "X-Requested-With" => "XMLHttpRequest",
        ])
            ->get('https://admin.sidikty.com/api/user-card/' . $userId . '/fingerprint')
            ->json();
            

        $fingerprint = $res['data'];

        Log::debug($fingerprint);

        $res = Http::withHeaders([
            "Content-Type" => "application/json",
            "Accept" => "application/json, text-plain, */*",
            "X-Requested-With" => "XMLHttpRequest",
        ])
        ->get('https://admin.sidikty.com/api/device/' . $sn)
        ->json();

        $device = $res['data'];
        Log::debug($device);
        $salt = md5($sn . $fingerprint . $device['vc'] . $time . $userId . ',' . $transactionCode . $device['vkey']);
        if (strtoupper($vStamp) == strtoupper($salt)) {
            // Transaction::where('id', $barcode)->update([
            //     'is_fingerprint_verified' => true,
            // ]);

            LogFinger::create([
                'barcode' => 'true',
                'finger' => 'true',
                'transaction_code' => $transactionCode,
                'store_id' => Session::get('mystore')
            ]);
           
        } else {
            Log::debug('invalid fingerprint');
        }
    }
}