<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductVariation;
use App\Models\Product\VariationValue;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index()
    {
        $data = ProductVariation::orderBy('id','desc')->get();
        return view('admin.variant.index',['page' => __('sidebar.v_product')],compact('data'));
    }

    public function create()
    {
        return view('admin.variant.create',['page' => __('produk.add_variant')]);
    }

    public function update($id)
    {
        $data = ProductVariation::findOrFail($id);
        return view('admin.variant.update',['page' => __('produk.variant_update')],compact('data'));
    }

    public function store(Request $request, $condition)
    {
        $this->validate($request,[
            'name'          => 'required',
            'value_name'    => 'required'
        ]);

        $condition == 'create' ? $data = new ProductVariation : $data = ProductVariation::findOrFail($request->id);
        $data->name     = $request->name;
        $data->save();

        $num = count($request->value_name);
        for ($x = 0; $x < $num; $x++) {
            if ($request->value_id[$x] != null) {
                $variasi = VariationValue::findOrFail($request->value_id[$x]);
            } else {
                $variasi = new VariationValue;
            }
            $variasi->name  = $request->value_name[$x];
            $variasi->product_variation_id = $data->id;
            $variasi->save();
        }

        return redirect()->route('variant.index')->with(['flash' => __('success')]);
    }

    public function deleteValue(Request $request, $id)
    {
        $data = VariationValue::findOrFail($request->id);
        return $this->deleteData($data,$request->id);
    }

    public function delete($id)
    {
        $data = ProductVariation::findOrFail($id);
        foreach($data->value as $value) {
            $value = VariationValue::where('product_variation_id',$id)->first();
            $this->deleteData($value,$value->id);
        }
        return $this->deleteData($data,$id);
    }
}
