<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::orderBy('name','asc')->get();
        return view('admin.customer.index',['page' => __('sidebar.customer')],compact('data'));
    }

    public function create()
    {
        return view('admin.customer.create',['page' => __('sidebar.add_customer')]);
    }

    public function update($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.update',['page' => __('customer.update')],compact('customer'));
    }

    public function store(Request $request, $condition)
    {
        $validator = Validator::make($request->all(),[
            'name'      => 'required', 
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

        $condition == 'create' ? $data = new Customer() : $data = Customer::findOrFail($request->id);
        $data->name = $request->name;
        $data->code = $request->code;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $request->address ? $data->address = $request->address : null;
        $request->city ? $data->city = $request->city : null;
        $request->state ? $data->state = $request->state : null;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Customer::findOrFail($id);
        return $this->deleteData($data,$id);
    }
}
