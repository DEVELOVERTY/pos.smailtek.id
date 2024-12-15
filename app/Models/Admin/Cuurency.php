<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuurency extends Model
{
    use HasFactory, SoftDeletes;

    public function store()
    {
        return $this->hasMany(Store::class,'currency_id');
    }
}
