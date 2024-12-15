<?php

namespace App\Models\Stock;

use App\Models\Product\Product;
use App\Models\Product\Variation;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjusmentDetail extends Model
{
    use HasFactory;

    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'transaction')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id')->withTrashed();
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class,'variation_id')->withTrashed();
    }
}
