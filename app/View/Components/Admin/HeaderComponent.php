<?php

namespace App\View\Components\Admin;

use App\Models\Admin\Setting;
use App\Models\Admin\Store;
use App\Models\Hrm\Attendance;
use Illuminate\Support\Facades\Session;
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
        $lang = array(
            'id'    => __('indonesian'),
            'en'    => __('english'),
            'chn'   => __('china'),
            // 'ar'    => __('arabic')
        );
        $storeSettings = Store::findOrFail(Session::get('mystore'));
        $currency   = $storeSettings->currency->symbol ?? '';
        $settings   = Setting::first();
        $attendance = Attendance::where('date', date('Y-m-d'))->where('user_id', Auth()->user()->id)->first();
        return view('components.admin.header-component',compact('lang','currency','settings','attendance'));
    }
}
