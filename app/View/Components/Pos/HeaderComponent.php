<?php

namespace App\View\Components\pos;

use App\Models\Admin\Customer;
use App\Models\Product\Category;
use Illuminate\View\Component;

class HeaderComponent extends Component
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
        $category = Category::where('is_root_parent',1)->get();
        $customer = Customer::all();
        return view('components.pos.header-component',compact('category','customer'));
    }
}
