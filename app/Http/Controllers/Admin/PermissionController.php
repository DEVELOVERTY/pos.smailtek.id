<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    { 
        $data = Permission::orderBy('id','asc')->get();
        return view('admin.usermanager.permission',['page' => __('sidebar.permission') ],compact('data'));
    }

    public function store(Request $request, $condition) 
    {
        $this->validate($request,[
            'name'      => 'required', 
        ]);

        $condition == 'create' ? $data = new Permission() : $data = Permission::findOrFail($request->id);
        $data->name = $request->name;
        $data->guard_name = 'web';
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Permission::findOrFail($id);
        return $this->deleteData($data,$id);
    }
}
