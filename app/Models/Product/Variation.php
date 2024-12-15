<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded  = ['id'];

    public $table    = 'variations';

    protected $with = ['media'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'sku';
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'imageable');
    }

    public function gambar()
    {
        return $this->hasOne(Media::class, 'imageable_id')->oldest();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function check()
    {
        return $this->hasMany(Media::class, 'imageable_id');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class,'variation_id')->where('store_id',Session::get('mystore'));
    }

    public function getStockTotalAttribute() {
        $total = $this->stock()->get()->sum('qty_available');
        return $total;
    }
}
