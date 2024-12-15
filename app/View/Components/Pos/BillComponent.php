<?php

namespace App\View\Components\Pos;

use App\Models\Admin\Customer;
use Illuminate\View\Component;

class BillComponent extends Component
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
        $customer = Customer::all();
        return view('components.pos.bill-component',compact('customer'));
    }
}
