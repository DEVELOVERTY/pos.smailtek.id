<?php

namespace App\Models\Stock;

use App\Models\Admin\Store;
use App\Models\Product\Stock;
use App\Models\Transaction\Purchase;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransferDetail extends Model
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

    public function stock()
    {
        return $this->belongsTo(Stock::class,'stock_id')->withTrashed();
    }

    public function fromstore()
    {
        return $this->belongsTo(Store::class,'from')->withTrashed();
    }

    public function tostore()
    {
        return $this->belongsTo(Store::class,'to')->withTrashed();
    }
}
