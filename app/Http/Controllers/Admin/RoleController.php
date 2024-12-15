<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $data = Role::all();
        return view('admin.usermanager.role', ['page' => __('sidebar.role')], compact('data'));
    }

    public function create()
    {
        $permission = Permission::all();
        return view('admin.usermanager.create_role', ['page' => __('user.add_role')], compact('permission'));
    }

    public function delete($id)
    {
        $data = Role::findOrFail($id);
        return $this->deleteData($data,$id);
    }

    public function update($id)
    {
        $role = Role::findOrFail($id);
        $used = array();
        $permission = Permission::all();
        
        foreach($permission as $p) {
            $rolehas = DB::table("role_has_permissions")
                        ->where("role_id",$role->id)
                        ->where("permission_id",$p->id)
                        ->first();
            if($rolehas != null) {
                $using = 'yes';
            }  else {
                $using = 'no';
            }
            $list = array(
                'used'  => $using,
                'name'  => $p->name,
                'id'    => $p->id,
            );
            array_push($used,$list);
        } 
        return view('admin.usermanager.update_role', ['page' => __('user.update_role')], compact('role', 'used'));
    }

    public function store(Request $request, $condition)
    {
        $this->validate($request, [
            'name'      => 'required',
        ]);
        $condition == 'create' ? $data = new Role : $data = Role::findOrFail($request->id);
        $data->name = $request->name;
        $data->save();
        $sum = count($request->permission_id);

        for ($x = 0; $x < $sum; $x++) {
            $getPermission = DB::table('role_has_permissions')
                ->where('permission_id', $request->permission_id[$x])
                ->where('role_id', $data->id)
                ->first();
            $getPermission == null ?  $data->givePermissionTo($request->permission_id[$x]) : null;
        }

        return redirect()->back()->with(['flash' => 'Data berhasil diperbaharui']);
    }

    public function deletePermission($id, $role)
    {
        $role = Role::findOrFail($role);
        $getPermission = DB::table('role_has_permissions')
            ->where('permission_id', $id)
            ->where('role_id', $role)
            ->first();
        $getPermission == null ?  $role->revokePermissionTo($id) : null;
        return true;
    }
}
