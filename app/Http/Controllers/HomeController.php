<?php

namespace App\Http\Controllers;

use App\Models\Admin\License;
use App\Models\Admin\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check() != null) {
            return redirect()->route('store.choose');
        }
        $data = Setting::first();

        return view('auth.login', ['page' => __('signin')], compact('data'));
    }

    public function redirect()
    {

        if (Auth::check() != null) {
            if (Auth()->user()->store_id == '0') {
                return redirect()->route('store.choose');
            } else {
                return redirect()->route('choose.store', Auth()->user()->store_id);
            }

            return redirect()->route('index');
        }
    }
}
