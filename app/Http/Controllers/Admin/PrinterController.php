<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrinterController extends Controller
{
    public function index()
    {
        $data = Printer::all();
        return view('admin.settings.printer', ['page' => __('sidebar.printer')], compact('data'));
    }

    public function create()
    {
        return view('admin.settings.create_printer', ['page' => __('settings.add_printer')]);
    }

    public function store(Request $request, $condition)
    { 

        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'type'      => 'required'
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

        $condition == 'create' ? $data = new Printer : $data = Printer::findOrFail($request->id);
        $data->name = $request->name;
        $data->type = $request->type;
        $request->path ? $data->path = $request->path : null;
        $request->url ? $data->url = $request->url : null;
        $request->char_per_line ? $data->char_per_line = $request->char_per_line : null;
        $request->ip_address ? $data->ip_address = $request->ip_address : null;
        return $this->saveData($data);
    }

    public function update($id)
    {
        $data = Printer::findOrFail($id);
        return view('admin.settings.update_printer', ['page' => __('settings.update_printer')], compact('data'));
    }

    public function delete($id)
    {
        $data = Printer::findOrFail($id);
        return $this->deleteData($data, $id);
    }
}
