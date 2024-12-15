<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionPayment extends Model
{
    use HasFactory, SoftDeletes;
    
    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'transaction_id')->withTrashed();
    }
}
