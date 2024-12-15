<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'is_root_parent' => 'boolean'
    ];

     /**
     * Get category childs
     */
    public function children()
    {
        return $this->hasMany(ExpenseCategory::class, 'parent_id')->where('is_root_parent', false);
    }

     /**
     * Get category parents
     */
    public function parent()
    {
        return $this->belongsTo(ExpenseCategory::class, 'parent_id');
    }

    
}
