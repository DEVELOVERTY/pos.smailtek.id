<?php

namespace App\Http\Controllers\Api\Sidik;
use App\Http\Controllers\Controller;
use App\Models\LogFinger;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function isTransactionFingerprintVerified()
    {
        return [
            'status' => 'success',
            'data' => optional(LogFinger::where('transaction_code', request('transaction_code'))->where('finger', 'true')->first())->finger ?? false,
        ];
    }
}