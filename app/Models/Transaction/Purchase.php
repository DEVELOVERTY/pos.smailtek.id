<?php

namespace App\Models\Transaction;

use App\Models\Product\Product;
use App\Models\Product\Variation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes; 
    
   
    public function variation()
    {
        return $this->belongsTo(Variation::class,'variation_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function quantity_remaining($id)
    {
        $data = Purchase::findOrFail($id);
        $quantity = ($data->quantity - $data->qty_sold) - $data->qty_adjusted - $data->qty_return;
        return $quantity;
    }
}
