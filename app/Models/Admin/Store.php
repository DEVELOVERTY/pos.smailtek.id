<?php

namespace App\Models\Admin;

use App\Models\Hrm\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    public function employee()
    {
        return $this->hasMany(Employee::class,'store_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id')->withTrashed();
    }
 
    public function currency()
    {
        return $this->belongsTo(Cuurency::class,'currency_id')->withTrashed();
    }

    public function printer()
    {
        return $this->belongsTo(Printer::class,'printer_id')->withTrashed();
    }

    public function storeToken()
    {
        return $this->hasOne(StoreToken::class,'store_id');
    }
}
