<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $data = Country::orderBy('name','asc')->get();
        return view('admin.settings.countries',['page' => __('sidebar.country') ],compact('data'));
    }

    public function store(Request $request, $condition) 
    {
        $this->validate($request,[
            'name'      => 'required'
        ]);

        $condition == 'create' ? $data = new Country : $data = Country::findOrFail($request->id);
        $data->name = $request->name;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Country::findOrFail($id);
        return $this->deleteData($data,$id);
    }
}
