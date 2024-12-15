<?php

namespace App\Http\Controllers\Salary;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Hrm\Department;
use App\Models\Salary\CuttingSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CuttingSalaryController extends Controller
{
    public function index()
    {
        $data = CuttingSalary::all();
        return view('admin.cutting.index',['page' => __('sidebar.deduction')],compact('data'));
    }

    public function create()
    {
        $department = Department::all();
        $priode = [
            'day'   => __('hrm.daily'),
            'month' => __('hrm.monthly'),
        ];
        return view('admin.cutting.create',['page' => __('hrm.add_deduction')],compact('department','priode'));
    }

    
    public function update($id)
    {
        $department = Department::all();
        $allowance = CuttingSalary::findOrFail($id);
        $priode = [
            'day'   => __('hrm.daily'),
            'month' => __('hrm.monthly'),
        ];
        return view('admin.cutting.update',['page' => __('hrm.update_deduction')],compact('department','allowance','priode'));
    }

    public function store(Request $request, $condition)
    {
        $validator = Validator::make($request->all(),[ 
            'name'      => 'required',
            'priode'      => 'required',
            'amount'    => 'required'
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

        $condition == 'create' ? $data = new CuttingSalary : $data = CuttingSalary::findOrFail($request->id);
        $request->designation_id ? $data->designation_id = $request->designation_id : $data->designation_id = 0;
        $data->store_id = Session::get('mystore');
        $data->name = $request->name;
        $data->priode = $request->priode;
        $data->amount = Helper::fresh_aprice($request->amount);
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = CuttingSalary::findOrFail($id);
        return $this->deleteData($data,$id);
    }
}
