<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MasterImport;
use App\Models\Admin\Setting;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index', ['page' => __('sidebar.general')], compact('settings'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'logo'      => 'mimes:jpg,jpeg,png'
        ]);

        $settings               = Setting::findOrFail(1);
        $settings->name         = $request->name;
        $request->logo ? $settings->logo = $this->uploadImage($request, 'logo', 'settings') : null;
        $request->default_email ? $settings->default_email = $request->default_email : null;
        $request->default_phone ? $settings->default_phone = $request->default_phone : null;

        // SMTP SETTING
        $request->smtp_host ? $settings->smtp_host = $request->smtp_host : null;
        $request->port ? $settings->port = $request->port : null;
        $request->username ? $settings->username = $request->username : null;
        $request->password ? $settings->password = $request->password : null;
        $request->encrypt ? $settings->encrypt = $request->encrypt : null;

        // FTP SETTING
        $request->host ? $settings->host = $request->host : null;
        $request->user ? $settings->user = $request->user : null;
        $request->pass ? $settings->pass = $request->pass : null;
        $request->rest_api ? $settings->rest_api = $request->rest_api : null;
        $settings->save();
    }

    public function import()
    {
        return view('admin.settings.import',['page' => "Import Data Master"]);
    }

    public function importStore(Request $request)
    {
        $this->validate($request, [
            'file'  => 'mimes:xlsx'
        ]);

        if ($request->file) {
            $file = $this->uploadImage($request, 'file', 'import/settings'); 
            $import = Excel::import(new MasterImport(), $file);
            if($import) { 
                return redirect()->back()->with(['flash' => "Import Data Berhasil"]);
            } else { 
                return redirect()->back()->with(['gagal' => "Terjadi kesalahan"]);
            }
        }

        return back()->with(['gagal' => 'Maaf, File Import Tidak Terbaca']);
    }


    public function bg_login_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bg_login' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $image = $request->file('bg_login');
        $imageData = base64_encode(file_get_contents($image));

        $imageRecord = Setting::findOrFail(1);
        $imageRecord->bg_login = $imageData;
        $imageRecord->save();

        return back()->with('success', 'Image uploaded successfully!');
    }
}
