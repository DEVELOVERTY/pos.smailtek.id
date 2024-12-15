<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;

    public function sell()
    {
        return $this->belongsTo(Sell::class,'sell_id')->withTrashed();
    }
}
