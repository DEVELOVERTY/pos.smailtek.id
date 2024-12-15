<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cuurency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $data = Cuurency::orderBy('country','asc')->get();
        return view('admin.settings.currency',['page' => __('sidebar.currency') ],compact('data'));
    }

    public function store(Request $request, $condition) 
    {
        $this->validate($request,[
            'currency'      => 'required',
            'code'      => 'required',
            'country'   => 'required',
            'symbol'    => 'required'
        ]);

        $condition == 'create' ? $data = new Cuurency : $data = Cuurency::findOrFail($request->id);
        $data->currency = $request->currency;
        $data->symbol = $request->symbol;
        $data->code     = $request->code;
        $data->country = $request->country;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Cuurency::findOrFail($id);
        return $this->deleteData($data,$id);
    }
}
