<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use App\Models\Product\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $data = Supplier::orderBy('name','asc')->get();
        return view('admin.supplier.index',['page' =>  __('sidebar.supplier')],compact('data'));
    }

    public function create()
    {
        $data = Country::orderBy('name','asc')->get();
        return view('admin.supplier.create',['page' => __('sidebar.add_supplier')],compact('data'));
    }

    public function update($id)
    {
        $data = Country::orderBy('name','asc')->get();
        $supplier = Supplier::findOrFail($id);
        return view('admin.supplier.update',['page' => __('supplier.update')],compact('data','supplier'));
    }

    public function delete($id)
    {
        $data = Supplier::findOrFail($id);
        return $this->deleteData($data,$id);
    }

    public function store(Request $request, $condition)
    {
        $this->validate($request,[
            'name'      => 'required',
            'code'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'country_id' => 'required',
        ]);

        $condition == 'create' ? $data = new Supplier : $data = Supplier::findOrFail($request->id);
        $data->name     = $request->name;
        $data->code     = $request->code;
        $data->email    = $request->email;
        $data->phone    = $request->phone;
        $data->country_id = $request->country_id;
        $request->address ? $data->address = $request->address : null;
        $request->city  ? $data->city = $request->city : null;
        $request->state ? $request->state = $request->state : null;
        $request->detail ? $request->detail = $request->detail : null;
        return $this->saveData($data);
    }
}
