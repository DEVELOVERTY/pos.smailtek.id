<?php

namespace App\Http\Controllers\Account;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Account\Expense;
use App\Models\Account\ExpenseCategory;
use App\Models\Admin\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $data = Expense::orderBy('id', 'desc')->paginate(20); 
        $category = ExpenseCategory::orderBy('name', 'asc')->get();
        if ($request->start_date || $request->category) {
            $data = Expense::where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->category ?
                    $query->where('category_id',$request->category) : '';
            })->paginate(20);
            $data->appends([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'category' => $request->category
            ]);
        }
        if ($request->ajax()) {
            return view('admin.expense.autoload_page', ['page' => __('sidebar.expense')], compact('data','category'));
        }
        return view('admin.expense.expense', ['page' => __('sidebar.expense')], compact('data','category'));
    }

    public function create()
    {
        $data = ExpenseCategory::where('parent_id', null)->orderBy('name', 'asc')->get();
        return view('admin.expense.create_expense',['page' => __('sidebar.add_expense')],compact('data'));
    }

    public function store(Request $request, $condition)
    {
        $validator = Validator::make($request->all(),[
            'ref_no'      => 'required',
            'category'      => 'required',
            'name'      => 'required',
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

        $condition == 'create' ? $data = new Expense : $data = Expense::findOrFail($request->id);
        $data->ref_no = $request->ref_no;
        $data->store_id = Session::get('mystore');
        $request->subcategory ? $data->category_id = $request->subcategory : $data->category_id = $request->category;
        $data->name = $request->name;
        $data->refund = $request->refund;
        $data->amount = Helper::fresh_aprice($request->amount);
        $request->detail ? $data->detail = $request->detail : null;
        $request->document ? $data->document = $this->uploadImage($request, 'document', 'expense') : null;
        return $this->saveData($data);
    }

    public function getSubcategory($id)
    {
        $data   = '<option value=""> ' . __('category.choose_subcategory')  . '</option>';
        $getData = ExpenseCategory::where('parent_id', $id)->get();
        foreach ($getData as $c) {
            $data .= '<option value=" ' . $c->id . '"> ' . $c->name . '</option>';
        }
        echo $data;
    }

    public function update($id)
    {
        $data = ExpenseCategory::where('parent_id', null)->orderBy('name', 'asc')->get();
        $expense = Expense::findOrFail($id);
        return view('admin.expense.update_expense',['page' => __('expense.update')],compact('data','expense'));
    }

    public function detail($id)
    {
        $data = Expense::findOrFail($id);
        return view('admin.expense.detail',['page' => __('expense.detail')],compact('data'));
    }

    public function delete($id)
    {
        $data = Expense::findOrFail($id);
        return $this->deleteData($data,$id);
    }

    public function report(Request $request)
    {
        $data = Expense::orderBy('id', 'desc')->paginate(20); 
        $our = Expense::all();
        $store = Store::all();
        $jumlahTotal = 0;
        foreach($our as $o) {
            $jumlahTotal += $o->amount;
        }
        $category = ExpenseCategory::orderBy('name', 'asc')->get();
        if ($request->start_date || $request->category || $request->store) {
            $data = Expense::where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->category ?
                    $query->where('category_id',$request->category) : '';
            })->where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id',$request->store) : '';
            })->paginate(20);
            $our = Expense::where(function ($query) use ($request) {
                return $request->start_date ?
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]) : '';
            })->where(function ($query) use ($request) {
                return $request->category ?
                    $query->where('category_id',$request->category) : '';
            })->where(function ($query) use ($request) {
                return $request->store ?
                    $query->where('store_id',$request->store) : '';
            })->get();
            $data->appends([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'category' => $request->category,
                'store'     => $request->store
            ]);
            $jumlahTotal = 0;
            foreach($our as $o) {
                $jumlahTotal += $o->amount;
            }
        }
        if ($request->ajax()) {
            return view('admin.reports.transaction.expense_page', ['page' => __('sidebar.expense_report')], compact('data','category','jumlahTotal','store'));
        }
        return view('admin.reports.transaction.expense', ['page' => __('sidebar.expense_report')], compact('data','category','jumlahTotal','store'));
    }
}
