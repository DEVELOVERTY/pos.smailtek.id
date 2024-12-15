<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use App\Models\Timezone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        $data       = User::all();
        return view('admin.usermanager.users', ['page' => __('sidebar.user')], compact('data'));
    }

    public function create()
    {
        $data = Role::all();
        $user = User::orderBy('name','asc');
        $store = Store::all();
        $timezone = Timezone::ZONETIME;
        return view('admin.usermanager.create_users', ['page' => __('user.add_user')], compact('data','user','store','timezone'));
    }

    public function update($id)
    {
        $data = Role::all();
        $users = User::findOrFail($id);
        $store = Store::all();
        $timezone = Timezone::ZONETIME;
        return view('admin.usermanager.update_users',['page' => __('user.update_user')],compact('data','users','store','timezone'));
    }

    public function store(Request $request)
    { 
        $validator = Validator::make($request->all(),[ 
            'store_id' => 'required',
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
            'timezone'  => 'required',
            'role_id'   => 'required'
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

        $data = new User();
        $data->store_id     = $request->store_id;
        $data->name         = $request->name;
        $data->email        = $request->email;
        $data->timezone     = $request->timezone;
        $data->password     = Hash::make($request->password);
        $data->role = $request->role_id;
        $request->photo ? $data->photo = $this->uploadImage($request, 'photo', 'user/photo') : null;
        $data->save();

        $getRole = Role::findOrFail($request->role_id);
        $data->assignRole($getRole->name);
        return redirect()->back()->with(['flash' => __('alert.created')]);

    }

    public function edit(Request $request)
    { 
        $validator = Validator::make($request->all(),[ 
            'store_id' => 'required',
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'. $request->id, 
            'role_id'   => 'required',
            'timezone'  => 'required'
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

        $data = User::findOrFail($request->id);
        $data->removeRole($data->role);
        $data->store_id     = $request->store_id;
        $data->name         = $request->name;
        $data->email        = $request->email;
        $data->timezone     = $request->timezone;
        $request->password ? $data->password     = Hash::make($request->password) : null; 
        $data->role = $request->role_id;
        $request->photo ? $data->photo = $this->uploadImage($request, 'photo', 'user/photo') : null;

        $getRole = Role::findOrFail($request->role_id);
        $data->assignRole($getRole->name);
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);
        return $this->deleteData($data, $id);
    }
}
