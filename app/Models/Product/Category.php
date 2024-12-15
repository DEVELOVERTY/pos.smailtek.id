<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded  = ['id'];
    public $table    = 'categories';

    protected $casts = [
        'is_root_parent' => 'boolean'
    ];

    /**
     * Get category childs
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('is_root_parent', false);
    }

     /**
     * Get category parents
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

     /**
     * Get product 
     */
    public function product()
    {
        return $this->hasMany(Product::class,'category_id');
    }

}
