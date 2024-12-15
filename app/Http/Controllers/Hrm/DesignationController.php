<?php

namespace App\Http\Controllers\Hrm;

use App\Http\Controllers\Controller;
use App\Models\Hrm\Department;
use App\Models\Hrm\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    public function index()
    {
        $data       = Designation::all();
        return view('admin.hrm.designation', ['page' => __('sidebar.designation')], compact('data'));
    }

    public function create()
    {
        $data = Department::all();
        return view('admin.hrm.add_designation', ['page' => __('hrm.add_designation')], compact('data'));
    }

    public function update($id)
    {
        $data = Department::all();
        $designation = Designation::findOrFail($id);
        return view('admin.hrm.update_designation',['page' => __('hrm.update_designation')],compact('data','designation'));
    }

    public function store(Request $request, $condition)
    { 
        $validator = Validator::make($request->all(),[ 
            'department_id' => 'required',
            'name'      => 'required'
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

        $condition == 'create' ? $data = new Designation : $data = Designation::findOrFail($request->id);
        $data->department_id = $request->department_id;
        $data->name     = $request->name;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Designation::findOrFail($id);
        return $this->deleteData($data, $id);
    }
}
