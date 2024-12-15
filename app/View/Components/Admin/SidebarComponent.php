<?php

namespace App\View\Components\Admin;

use App\Models\Admin\Setting;
use Illuminate\View\Component;

class SidebarComponent extends Component
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
        $data = Setting::first();
        return view('components.admin.sidebar-component',compact('data'));
    }
}
