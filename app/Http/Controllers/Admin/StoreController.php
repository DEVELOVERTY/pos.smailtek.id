<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Models\Admin\Country;
use App\Models\Admin\Cuurency;
use App\Models\Admin\Printer;
use App\Models\Admin\Setting;
use App\Models\Admin\Store;
use App\Models\Admin\StoreToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{

    public function index()
    {
        $setting = Setting::first();
        $data = Store::with('storeToken')->get(); // Load token untuk setiap toko

        if (Auth()->user()->store_id != '0') {
            return redirect()->route('choose.store', Auth()->user()->store_id);
        }

        return view('auth.choose_store', ['page' => __('sidebar.choose_store')], compact('data', 'setting'));
    }

    public function choose($id)
    {
        Session::put('mystore', $id);
        return redirect()->route('index');
    }

    public function create()
    {
        $data = [
            'country'   => Country::orderBy('name', 'desc')->get(),
            'currency'  => Cuurency::all(),
            'printer'   => Printer::all()
        ];

        $reference_format = array(
            '1'     => 'sample 01',
            '2'     => 'sample 02',
        );
        return view('admin.store.create', ['page' => __('sidebar.add_store')], compact('data', 'reference_format'));
    }

    public function update()
    {
        $data = [
            'country'   => Country::orderBy('name', 'desc')->get(),
            'currency'  => Cuurency::all(),
            'printer'   => Printer::all()
        ];

        $reference_format = array(
            '1'     => 'sample 01',
            '2'     => 'sample 02',
        );

        $store  = Store::findOrFail(Session::get('mystore'));
        return view('admin.store.update', ['page' => __('sidebar.update_store')], compact('data', 'reference_format', 'store'));
    }

    public function store(Request $request, $condition)
    {

        $validator = Validator::make($request->all(), [
            'country_id'        => 'required',
            'currency_id'       => 'required',
            'printer_id'        => 'required',
            'name'              => 'required',
            'code'              => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'zip_code'          => 'required',
            'address'           => 'required',
            'after_sell'        => 'required',
            'tax'               => 'required',
            'zakat'             => 'required',
            'sound'             => 'required',
            'currency_position' => 'required',
            'long'              => 'required',
            'lang'              => 'required'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'error'
                ]);
            }
        }

        $condition == 'create' ? $data = new Store : $data = Store::findOrFail(Session::get('mystore'));
        $data->country_id = $request->country_id;
        $data->currency_id = $request->currency_id;
        $data->printer_id = $request->printer_id;
        $data->name         = $request->name;
        $data->code         = $request->code;
        $data->email        = $request->email;
        $data->phone        = $request->phone;
        $data->zip_code     = $request->zip_code;
        $data->address      = $request->address;
        $data->after_sell   = $request->after_sell;
        $data->tax          = $request->tax;
        $data->zakat        = $request->zakat;
        $data->sound        = $request->sound;
        $data->currency_position = $request->currency_position;
        $data->long ? $data->long = $request->long : null;
        $data->lang ? $data->lang = $request->lang : null;
        $request->footer_text ? $data->footer_text = $request->footer_text : null;
        $request->long  ? $data->long = $request->long : null;
        $request->lang ? $data->lang = $request->lang : null;
        $data->reference_format = $request->reference_format;
        $request->gst ? $data->gst = $request->gst : null;
        $request->vat ? $data->vat = $request->vat : null;
        return $this->saveData($data);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', __('alert.field'));
            }
        });
    }
}
