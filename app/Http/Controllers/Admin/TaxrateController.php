<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Taxrate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaxrateController extends Controller
{
    public function index()
    {
        $data = Taxrate::all();
        return view('admin.settings.taxrate',['page' => __('sidebar.tax_persentation')],compact('data'));
    }

    public function create()
    {
        return view('admin.settings.create_taxrate',['page' =>  __('settings.add_taxrate')]);
    }

    public function update($id)
    {
        $data = Taxrate::findOrFail($id);
        return view('admin.settings.update_taxrate',['page' =>  __('settings.update_taxrate')],compact('data'));
    }

    public function store(Request $request, $condition)
    {
        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'code'      => 'required',
            'taxrate'   => 'required'
        ]);
        
        if ($validator->fails()) {
            if($request->ajax())
            {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'error'
                ]);
            }
        }

        $condition == 'create' ? $data = new Taxrate : $data = Taxrate::findOrFail($request->id);
        $data->name     = $request->name;
        $data->code     = $request->code;
        $data->taxrate  = $request->taxrate;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Taxrate::findOrFail($id);
        return $this->deleteData($data,$id);
    }


}
