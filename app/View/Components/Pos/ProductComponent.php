<?php

namespace App\View\Components\Pos;

use App\Models\Product\Category as ProductCategory;
use Illuminate\View\Component; 

class ProductComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $category = ProductCategory::all();
        return view('components.pos.product-component',compact('category'));
    }
}
