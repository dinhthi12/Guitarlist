<?php

namespace App\Http\Controllers;

use App\Exports\ExportName;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
class CategoryController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        //gọi danh sách danh mục và hiển thị
        $categoryList = Category::paginate(5);
        view()->share('categoryList', $categoryList);
        //trả về view danh mục
        return view('admin.pages.categories.index');
    }
    public function loadEdit($id)
    {
        //tìm kiếm danh mục tương ứng theo id
        $cate = Category::find($id);
        //trả về view để edit
        return view('admin.pages.categories.edit', ['cate' => $cate]);
    }

    public function edit(Request $request)
    {
        //thực hiện edit
        $cate = Category::find($request->id);
        $cate->name = $request->name;
        //save
        $cate->save();
        //trả về trang danh mục + thông báo
        return redirect('admin/categories/index')->with('success', 'Cập nhật danh mục thành công');
    }
    public function delete($id)
    {
        //tìm danh mục theo id
        $cate = Category::find($id);
        //kiểm tra danh mục có danh mục con hay không
        if ($cate->Cate_item()->exists()) {
            return redirect('admin/categories/index')->with('error', 'Không thể xóa danh mục có danh mục con');
        }
        //không có thì xoá + thông báo
        $cate->delete();
        return redirect('admin/categories/index')->with('success', 'Xóa danh mục thành công');
    }
    public function create(Request $request)
    {
        //thêm danh mục mới
        $cate = new Category();
        $cate->name = $request->name;
        $cate->save();

        return redirect('admin/categories/index')->with('success', 'Thêm danh mục thành công');
    }
    public function export()
    {
        //Dòng này sử dụng thư viện "Maatwebsite/Excel" để tạo và tải về một tệp Excel
        return Excel::download(new ExportName(), 'export-data.xlsx');
    }
}
