<?php

namespace App\Http\Controllers\Hrm;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Hrm\Department;
use App\Models\Hrm\Designation;
use App\Models\Hrm\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $data       = Employee::all();
        return view('admin.employee.index', ['page' => __('employee')], compact('data'));
    }

    public function create()
    {
        $data = Department::all();
        $user = User::orderBy('name','asc')->get();
        return view('admin.employee.add_employee', ['page' => __('add_employee')], compact('data','user'));
    }

    public function update($id)
    {
        $data = Department::all();
        $user = User::orderBy('name','asc')->get();
        $employee = Employee::findOrFail($id);
        return view('admin.employee.update_employee',['page' => __('update_employee')],compact('data','employee','user'));
    }

    public function store(Request $request, $condition)
    {
        if($condition == 'create') { 
            $validator = Validator::make($request->all(),[ 
                'designation_id'    => 'required',
                'user_id'           => 'required|unique:employees,user_id',
                'salary'            => 'required', 
                'phone'             => 'required',
            ]); 
        } else {
            $validator = Validator::make($request->all(),[ 
                'designation_id'    => 'required',
                'user_id'           => 'required|unique:employees,user_id,'. $request->id,
                'salary'            => 'required', 
                'phone'             => 'required'
            ]);  
        }

        if ($validator->fails()) {
            if($request->ajax())
            {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'error'
                ]);
            }
        }
       

        $condition == 'create' ? $data = new Employee : $data = Employee::findOrFail($request->id); 
        $data->designation_id = $request->designation_id;
        $data->user_id              = $request->user_id; 
        $data->salary               = Helper::fresh_aprice($request->salary); 
        $request->address ? $data->address = $request->address : null;
        $request->about ? $data->about = $request->about : null;
        $request->phone ? $data->phone = $request->phone : null;
        $request->date_birth ? $data->date_birth = $request->date_birth : null;
        $request->status ? $data->status = $request->status : null;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Employee::findOrFail($id);
        return $this->deleteData($data, $id);
    }
}
