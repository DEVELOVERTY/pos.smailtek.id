<?php

namespace App\Models\Product;

use App\Models\Admin\Taxrate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'sku',
        'type',
        'category_id',
        'brand_id',
        'unit_id',
        'barcode_type',
        'alert_quantity',
        'weight',
        'description',
        'tax_id',
        'image',
        'status',
    ];
    public $table    = 'products';

    public function variant()
    {
        return $this->hasMany(Variation::class,'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id')->withTrashed();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id')->withTrashed();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id')->withTrashed();
    }

    public function tax()
    {
        return $this->belongsTo(Taxrate::class,'tax_id')->withTrashed();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class,'product_id')->where('store_id',Session::get('mystore'));
    }

    public function getPriceSellRangeAttribute() {
        $min = $this->variant()->get()->min('selling_price');
        $max = $this->variant()->get()->max('selling_price');
        if($min != $max) {
            return number_format($min) . ' - ' . number_format($max);
        } else {
            return number_format($min);
        }
       
    }

    public function getPricePurchaseRangeAttribute() {
        $min = $this->variant()->get()->min('purchase_price'); 
        $max = $this->variant()->get()->max('purchase_price');
        if($min != $max) {
            return number_format($min) . ' - ' . number_format($max);
        } else {
            return number_format($min);
        }
    }

    public function getStockTotalAttribute()
    {
        $total = $this->stock()->get()->sum('qty_available');
        return $total;
    }

   
}
