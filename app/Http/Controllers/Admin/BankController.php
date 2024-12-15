<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $data = Bank::orderBy('bank_name','asc')->get();
        return view('admin.settings.bank',['page' => __('sidebar.bank') ],compact('data'));
    }

    public function store(Request $request, $condition) 
    {
        $this->validate($request,[
            'bank_name'      => 'required',
            'bank_code'      => 'required'
        ]);

        $condition == 'create' ? $data = new Bank() : $data = Bank::findOrFail($request->id);
        $data->bank_name = $request->bank_name;
        $data->bank_code = $request->bank_code;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Bank::findOrFail($id);
        return $this->deleteData($data,$id);
    }

    public function getbank()
    { 
        $getBank     = Bank::all(); 
        return response()->json([
            'bank'       => $getBank,
        ]);
    }
}
