<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Imports\CategoryImport;
use App\Models\Product\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::where('is_root_parent',1)->orderBy('name', 'asc')->get();
        return view('admin.category.index', ['page' => __('sidebar.category')], compact('data'));
    }

    public function subcategory()
    {
        $data = Category::where('is_root_parent',0)->orderBy('name', 'asc')->get();
        return view('admin.category.subcategory', ['page' => __('sidebar.subcategory')], compact('data'));
    }

    public function create()
    {
        $data = Category::orderBy('name', 'asc')->get();
        return view('admin.category.create', ['page' => __('sidebar.add_category')], compact('data'));
    }

    public function subCreate()
    {
        $data = Category::where('is_root_parent',1)->orderBy('name', 'asc')->get();
        return view('admin.category.create_sub', ['page' => __('category.add_subcategory')], compact('data'));
    }

    public function update($id)
    {
        $data = Category::orderBy('name', 'asc')->get();
        $category = Category::findOrFail($id);
        return view('admin.category.update', ['page' => __('category.update_category')], compact('data', 'category'));
    }

    public function updateSub($id)
    {
        $data = Category::where('is_root_parent',1)->orderBy('name', 'asc')->get();
        $category = Category::findOrFail($id);
        return view('admin.category.update_sub', ['page' => __('category.update_subcategory')], compact('data', 'category'));
    }

    public function byCat($id)
    {
        $data = Category::where('parent_id',$id)->orderBy('name','asc')->get();
        return view('admin.category.subcategory',['page' => __('by_category')],compact('data'));
    }

    public function store(Request $request, $condition)
    {
        $this->validate($request, [
            'name'      => 'required',
            'image'     => 'mimes:jpg,jpeg,png'
        ]);

        $condition == 'create' ? $data = new Category : $data = Category::findOrFail($request->id);
        $data->name    = $request->name;
        $request->image ? $data->image = $this->uploadImage($request, 'image', 'category') : null;
        $request->detail ? $data->detail = $request->detail : null;
        $request->parent_id ? $data->parent_id = $request->parent_id : $data->is_root_parent = 1;
        $request->parent_id ? $data->is_root_parent = 0 : null;
        return $this->saveData($data);
    }

    public function delete($id)
    {
        $data = Category::findOrFail($id);
        return $this->deleteData($data, $id);
    }

    public function import()
    {
        return view('admin.category.import',["page" => "Import Kategori & Subkategori"]);
    }

    public function importStore(Request $request)
    {
        $this->validate($request, [
            'file'  => 'mimes:xlsx'
        ]);

        if ($request->file) {
            $file = $this->uploadImage($request, 'file', 'import/category'); 
            $import = Excel::import(new CategoryImport(), $file);
            if($import) { 
                return redirect()->back()->with(['flash' => "Import Data Berhasil"]);
            } else { 
                return redirect()->back()->with(['gagal' => "Terjadi kesalahan"]);
            }
        }

        return back()->with(['gagal' => 'Maaf, File Import Tidak Terbaca']);
    }
}
