<?php

namespace App\Models\Account;

use App\Models\Admin\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class,'category_id')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id')->withTrashed();
    }
 
}
