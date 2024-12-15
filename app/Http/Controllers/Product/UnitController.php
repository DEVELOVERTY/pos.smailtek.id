<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        $data = Unit::all();
        return view('admin.unit.index',['page' => __('sidebar.unit')],compact('data'));
    }

    public function create()
    {
        return view('admin.unit.create',['page' => __('settings.add_unit')]);
    }

    public function update($id)
    {
        $data = Unit::findOrFail($id);
        return view('admin.unit.update',['page' => __('settings.update_unit') ],compact('data'));
    }

    public function store(Request $request, $condition)
    {
        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'code'      => 'required',
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

        $condition == 'create' ? $data = new Unit : $data = Unit::findOrFail($request->id);
        $data->name = $request->name;
        $data->code = $request->code;
        $request->detail ? $data->detail = $request->detail : null;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Unit::findOrFail($id);
        return $this->deleteData($data,$id);
    }
}
