<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $data = DB::table('category')->paginate(5);
        view()->share('data', $data);
    }
    public function index()
    {
        return view('admin.pages.categories.index');
    }
    public function loadEdit($id)
    {
        $cate = Category::find($id);

        return view('admin.pages.categories.edit', ['cate' => $cate]);
    }

    public function edit(Request $request)
    {
        $cate = Category::find($request->id);
        $cate->name = $request->name;

        $cate->save();

        return redirect('admin/categories/index')->with('success', 'Cập nhật danh mục thành công');
    }
    public function delete($id)
    {
        $cate = Category::find($id);

        if ($cate->Cate_item()->exists()) {
            return redirect('admin/categories/index')->with('error', 'Không thể xóa danh mục có danh mục con');
        }

        $cate->delete();
        return redirect('admin/categories/index')->with('success', 'Xóa danh mục thành công');
    }
    public function create(Request $request)
    {
        $cate= new Category();
        $cate->name=$request->name;
        $cate->save();

        return redirect('admin/categories/index')->with('success', 'Thêm danh mục thành công');
    }
}
