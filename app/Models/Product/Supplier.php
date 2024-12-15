<?php

namespace App\Models\Product;

use App\Models\Admin\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;
    
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id')->withTrashed();
    }
}
