<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CateItem;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        //thực hiện truy vấn toàn bộ dữ liệu từ bảng Category trong cơ sở dữ liệu và lưu trữ chúng trong biến $allCate
        $allCate = Category::all();
        //sử dụng view()->share() để chia sẻ dữ liệu $allCate với tất cả các view
        //có thể truy cập biến $allCate trong mọi view mà không cần truyền biến này qua các hàm return view()
        view()->share('allCate', $allCate);
    }
    public function getProByCate($id)
    {
        $category = Category::find($id);
        $listPro = $category->Product()->paginate(5);
        $cti_bar = Category::find($id)->Cate_item;
        return view('client.pages.categories.index', ['listPro' => $listPro, 'cti_bar' => $cti_bar]);
    }

     public function getProByCateItem($id)
    {
        $categoryItem = CateItem::find($id);
        $listPro = $categoryItem->Product()->paginate(10);
        $cti_bar = CateItem::where('category_id', $categoryItem->category_id)->get();

        return view('client.pages.categories.index',['listPro'=>$listPro,'cti_bar'=>$cti_bar]);
    }

    public function getCateItemByCate(Request $r)
    {
        $cateItems = CateItem::where('category_id', '=', $r->id_cate)->get();
        return response()->json($cateItems);
    }
}
