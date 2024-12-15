<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SettingsHrm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsHrmController extends Controller
{
    public function index()
    {
        $hrm = SettingsHrm::first();
        return view('admin.settings.hrm',['page' => __('sidebar.hrm')],compact('hrm'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'min_check_int'      => 'required',
            'max_check_int'      => 'required',
            'min_check_out'      => 'required',
            'attendance_to_salary' => 'required',
            'salary_tax'        => 'required'
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

        $data = SettingsHrm::first();
        $data->min_check_out = $request->min_check_out;
        $data->max_check_int = $request->max_check_int;
        $data->min_check_int = $request->min_check_int;
        $data->attendance_to_salary = $request->attendance_to_salary;
        $data->attendance_in_late = $request->attendance_in_late;
        $data->attendance_to_cutting = $request->attendance_to_cutting;
        $data->salary_tax = $request->salary_tax;
        return $this->saveData($data);
    }
}
