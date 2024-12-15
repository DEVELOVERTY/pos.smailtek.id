<?php

namespace App\Models\Transaction;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnDetail extends Model
{
    use HasFactory;

    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'transaction_id')->withTrashed();
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class,'purchase_id')->withTrashed();
    }

   
}
