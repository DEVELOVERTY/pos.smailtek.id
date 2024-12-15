<?php

namespace App\View\Components\PosMobile;

use App\Models\Product\Category;
use Illuminate\View\Component;

class CategoryComponent extends Component
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
        $category = Category::all();
        return view('components.pos-mobile.category-component',compact('category'));
    }
}
