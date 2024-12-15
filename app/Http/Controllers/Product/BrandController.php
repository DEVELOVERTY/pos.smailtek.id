<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $data = Brand::all();
        return view('admin.brand.index',['page' => __('sidebar.brand')],compact('data'));
    }

    public function create()
    {
        return view('admin.brand.create',['page' => __('settings.add_brand')]);
    }

    public function update($id)
    {
        $data = Brand::findOrFail($id);
        return view('admin.brand.update',['page' => __('settings.update_brand')],compact('data'));
    }

    public function store(Request $request, $condition)
    {
        $this->validate($request,[
            'name'      => 'required',
            'code'      => 'required',
            'image'     => 'mimes:jpg,jpeg,png'
        ]);


        $condition == 'create' ? $data = new Brand : $data = Brand::findOrFail($request->id);
        $data->name = $request->name;
        $data->code = $request->code;
        $request->detail ? $data->detail = $request->detail : null;
        $request->image ? $data->image = $this->uploadImage($request, 'image', 'brand') : null;
        $data->save();
        return json_encode($data);
    }

    public function delete($id)
    {
        $data = Brand::findOrFail($id);
        return $this->deleteData($data,$id);
    }
}
