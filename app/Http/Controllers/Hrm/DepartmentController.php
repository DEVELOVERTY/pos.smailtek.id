<?php

namespace App\Http\Controllers\Hrm;

use App\Http\Controllers\Controller;
use App\Models\Hrm\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $data = Department::all();
        return view('admin.hrm.department',['page' => __('sidebar.department')],compact('data'));
    }

    public function store(Request $request, $condition)
    {
        $this->validate($request, [
            'name'      => 'required'
        ]);

        $condition == 'create' ? $data = new Department : $data = Department::findOrFail($request->id);
        $data->name     = $request->name;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Department::findOrFail($id);
        return $this->deleteData($data,$id);
    }
}
