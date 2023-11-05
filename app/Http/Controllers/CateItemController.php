<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CateItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CateItemController extends Controller
{
    //tương tự category
    public function __construct()
    {
    }
    public function index($id)
    {
        $cateItems = CateItem::where('category_id', $id)->paginate(5);
        $cate = Category::find($id);
        return view('admin.pages.categories.cateitems.index', compact('cateItems', 'cate'));
    }
    public function loadEdit($id)
    {
        $cateItem = CateItem::find($id);
        $id = $cateItem->category_id;

        $cateItems = CateItem::where('category_id', '=', $id)->get();
        return view('admin.pages.categories.cateitems.edit', ['cateItem' => $cateItem, 'cateItems' => $cateItems]);
    }

    public function edit(Request $request)
    {

        $cate = CateItem::find($request->id);
        $cate->name = $request->name;
        $cate->category_id = $request->category_id;
        $cate->save();

        return redirect('admin/cateitems/index/' . $cate->category_id)->with('success', 'Cập nhật danh mục con thành công');
    }

    public function create(Request $request)
    {
        $cate = new CateItem();
        $cate->name = $request->name;
        $cate->category_id = $request->category_id;
        $cate->save();
        return redirect('admin/cateitems/index/' . $cate->category_id)->with('success', 'Cập nhật danh mục con thành công');
    }

    public function delete($id)
    {
        $cate = CateItem::find($id);
        $id = $cate->category_id;
        if ($cate->Product()->exists()) {
            return redirect('admin/cateitems/index/' . $id)->with('error', 'Không thể xóa danh mục con có sản phẩm');
        }
        $cate->delete();

        return redirect('admin/cateitems/index/' . $id)->with('success', 'Cập nhật danh mục con thành công');
    }
}
