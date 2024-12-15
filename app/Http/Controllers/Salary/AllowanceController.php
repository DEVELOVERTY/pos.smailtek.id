<?php

namespace App\Http\Controllers\Salary;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use App\Models\Hrm\Department;
use App\Models\Hrm\Designation;
use App\Models\Salary\Allowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AllowanceController extends Controller
{
    public function index()
    {
        $data = Allowance::all();
        return view('admin.allowance.index', ['page' => __('sidebar.e_allowance')], compact('data'));
    }

    public function create()
    {
        $department = Department::all();
        $priode = [
            'day'   => 'Harian',
            'month' => 'Bulanan',
        ];
        return view('admin.allowance.create', ['page' => __('hrm.add_allowance')], compact('department', 'priode'));
    }

    public function getDesignation($id)
    {
        $data   = '<option value=""> ' . __('hrm.choose_designation') . ' </option>';
        $getData = Designation::where('department_id', $id)->get();
        foreach ($getData as $c) {
            $data .= '<option value="' . $c->id . '"> ' . $c->name . '</option>';
        }
        echo $data;
    }

    public function update($id)
    {
        $department = Department::all();
        $allowance = Allowance::findOrFail($id);
        $priode = [
            'day'   => 'Harian',
            'month' => 'Bulanan',
        ];
        return view('admin.allowance.update', ['page' => __('hrm.update_allowance')], compact('department', 'allowance', 'priode'));
    }

    public function store(Request $request, $condition)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'priode'      => 'required',
            'amount'    => 'required'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'error'
                ]);
            }
        }

        $condition == 'create' ? $data = new Allowance : $data = Allowance::findOrFail($request->id);
        $request->designation_id ? $data->designation_id = $request->designation_id : $data->designation_id = 0;
        $data->store_id = Session::get('mystore');
        $data->name = $request->name;
        $data->priode = $request->priode;
        $data->amount = Helper::fresh_aprice($request->amount);
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Allowance::findOrFail($id);
        return $this->deleteData($data, $id);
    }
}
