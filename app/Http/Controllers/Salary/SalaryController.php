<?php

namespace App\Http\Controllers\Salary;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Setting;
use App\Models\Admin\SettingsHrm;
use App\Models\Admin\Store;
use App\Models\Hrm\Department;
use App\Models\Hrm\Employee;
use App\Models\Salary\Allowance;
use App\Models\Salary\CuttingSalary;
use App\Models\Salary\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SalaryController extends Controller
{
    public function generate(Request $request)
    {
        $department = Department::all();
        if ($request->employee && $request->date) {
            $store = Store::findOrFail(Session::get('mystore'));
            $year = substr($request->date, 0, 4);
            $month = substr($request->date, 5, 2);
            $cutting = CuttingSalary::orderBy('name', 'desc')->get();
            $allowance = Allowance::orderBy('name', 'desc')->get();
            $setting = Setting::first();
            $setthrm = SettingsHrm::first();
            $employee = Employee::findOrFail($request->employee);
            return view('admin.salary.index', ['page' => 'Generate Gaji'], compact(
                'department',
                'employee',
                'store',
                'setting',
                'setthrm',
                'month',
                'year',
                'cutting',
                'allowance'
            ));
        }

        return view('admin.salary.index', ['page' => __('sidebar.generate_slip')], compact('department'));
    }

    public function getEmployee($id)
    {
        $data   = '<option value=""> Pilih Pegawai </option>';
        $getData = Employee::where('designation_id', $id)->get();
        foreach ($getData as $c) {
            $data .= '<option value="' . $c->id . '"> ' . $c->user->name . '</option>';
        }
        echo $data;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id'   => 'required',
            'employee_id' => 'required',
        ]);

        $getSalary = Salary::where('employee_id', $request->employee_id)->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->first();
        if ($getSalary == null) {
            $data = new Salary();
            $data->user_id = $request->user_id;
            $data->employee_id = $request->employee_id;
            $data->store_id = Session::get('mystore');
            $data->designation_id = $request->designation;
            $data->cutting = $request->cutting;
            $data->salary = $request->salary;
            $data->tax = $request->tax;
            $data->allowance = $request->allowance;
            $request->bonus ? $data->bonus = Helper::fresh_aprice($request->bonus) : true;
            $data->date = date('Y-m-d');
            $data->attendance_this_month = $request->attendance_this_month;
            $data->total_work = $request->total_work;
            $total = $request->total;
            if ($request->bonus != 0 || $request->bonus != null) {
                $total = $request->total + Helper::fresh_aprice($request->bonus);
            }

            $data->total = $total;
            $request->note ? $data->note = $request->note : true;
            $data->save();
            return redirect()->route('generate.salary')->with(['flash' => __('alert.salary_saved')]);
        } else {
            return redirect()->back()->with(['gagal' => __('alert.generate_salary_error')]);
        }
    }

    public function list(Request $request)
    {
        $department = Department::all();
        if($request->designation_id && $request->date) {
            $data = Salary::where('designation_id',$request->designation_id) ->whereYear('created_at',substr($request->date,0,4))->whereMonth('created_at',substr($request->date,5,2))->orderBy('id','desc')->get();
            return view('admin.salary.list',['page' => __('sidebar.salary_list')],compact('department','data'));
        }
        return view('admin.salary.list',['page' => __("sidebar.salary_list")],compact('department'));   
    }

    public function detail($id)
    {
        $salary = Salary::findOrFail($id);
        $setting = Setting::first();
        return view('admin.salary.detail',['page' => __('hrm.salary_detail')],compact('salary','setting'));
    }

    public function print($id)
    {
        $salary = Salary::findOrFail($id);
        $setting = Setting::first();
        return view('admin.salary.print',['page' => __('hrm.salary_detail')],compact('salary','setting'));
    }

    public function updatePayment(Request $request)
    {
        $data = Salary::findOrFail($request->id);
        $data->status = $request->status;
        $data->method_payment = $request->method_payment;
        return $this->saveData($data);
    }
}
