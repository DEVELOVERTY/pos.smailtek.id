<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $data = ExpenseCategory::where('is_root_parent',1)->orderBy('name', 'asc')->get();
        return view('admin.expense.index', ['page' => __('sidebar.expense_category')], compact('data'));
    }

    public function subcategory()
    {
        $data = ExpenseCategory::where('is_root_parent',0)->orderBy('name', 'asc')->get();
        return view('admin.expense.subcategory', ['page' => __('sidebar.expense_subcategory')], compact('data'));
    }

    public function create()
    {
        $data = ExpenseCategory::orderBy('name', 'asc')->get();
        return view('admin.expense.create', ['page' => __('sidebar.add_category') ], compact('data'));
    }

    public function subCreate()
    {
        $data = ExpenseCategory::where('is_root_parent',1)->orderBy('name', 'asc')->get();
        return view('admin.expense.create_sub', ['page' => __('category.add_subcategory')], compact('data'));
    }

    public function update($id)
    {
        $data = ExpenseCategory::orderBy('name', 'asc')->get();
        $category = ExpenseCategory::findOrFail($id);
        return view('admin.expense.update', ['page' => __('category.update_category')], compact('data', 'category'));
    }

    public function updateSub($id)
    {
        $data = ExpenseCategory::where('is_root_parent',1)->orderBy('name', 'asc')->get();
        $category = ExpenseCategory::findOrFail($id);
        return view('admin.expense.update_sub', ['page' => __('category.update_subcategory')], compact('data', 'category'));
    }

    public function byCat($id)
    {
        $data = ExpenseCategory::where('parent_id',$id)->orderBy('name','asc')->get();
        return view('admin.expense.subcategory',['page' => __('category.bycategory')],compact('data'));
    }

    public function store(Request $request, $condition)
    {
        $this->validate($request, [
            'name'      => 'required',
            'image'     => 'mimes:jpg,jpeg,png'
        ]);

        $condition == 'create' ? $data = new ExpenseCategory : $data = ExpenseCategory::findOrFail($request->id);
        $data->name    = $request->name;
        $request->image ? $data->image = $this->uploadImage($request, 'image', 'expense-category') : null;
        $request->detail ? $data->detail = $request->detail : null;
        $request->parent_id ? $data->parent_id = $request->parent_id : $data->is_root_parent = 1;
        $request->parent_id ? $data->is_root_parent = 0 : null;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = ExpenseCategory::findOrFail($id);
        return $this->deleteData($data, $id);
    }
}
