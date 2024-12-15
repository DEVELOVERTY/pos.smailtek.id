<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoxController extends Controller
{
    public function index()
    {
        $data = Box::all();
        return view('admin.box.index',['page' => __('sidebar.box')],compact('data'));
    }

    public function create()
    {
        return view('admin.box.create',['page' => __('settings.add_box')]);
    }

    public function update($id)
    {
        $data = Box::findOrFail($id);
        return view('admin.box.update',['page' => __('settings.update_box') ],compact('data'));
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
        $condition == 'create' ? $data = new Box : $data = Box::findOrFail($request->id);
        $data->name = $request->name;
        $data->code = $request->code;
        $request->detail ? $data->detail = $request->detail : null;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Box::findOrFail($id);
        return $this->deleteData($data,$id);
    }
}
