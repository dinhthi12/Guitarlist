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
    //func này lấy danh sách sp thuộc category cụ thể theo id
    public function getProByCate($id)
    {
        //lấy danh mục dựa theo id
        $category = Category::find($id);
        //sau khi có danh mục -> lấy danh sách sp theo danh mục dựa theo quan hệ model -> phân trang
        $listPro = $category->Product()->paginate(5);
        //lấy danh mục con theo danh mục
        $cti_bar = Category::find($id)->Cate_item;
        //trả về view
        return view('client.pages.categories.index', ['listPro' => $listPro, 'cti_bar' => $cti_bar]);
    }
    //func này lấy danh sách sp theo category item
    //luồng đi giống func trên
    public function getProByCateItem($id)
    {
        $categoryItem = CateItem::find($id);
        $listPro = $categoryItem->Product()->paginate(10);
        // tìm kiếm tất cả các mục con của cùng một danh mục mà mục con đang được xem.
        //Nó lấy danh sách các mục con dựa trên trường category_id của mục con và so sánh nó với category_id của mục con hiện tại.
        $cti_bar = CateItem::where('category_id', $categoryItem->category_id)->get();

        return view('client.pages.categories.index', ['listPro' => $listPro, 'cti_bar' => $cti_bar]);
    }

    public function getCateItemByCate(Request $request)
    {
        //dòng này sử dụng model CateItem để truy vấn danh sách các mục con.
        //sử dụng điều kiện để lấy các mục con có category_id bằng giá trị được truyền vào từ request ($r->id_cate),
        //và sau đó sử dụng get() để lấy danh sách kết quả từ truy vấn.
        //SELECT * FROM cate_items WHERE category_id = :id_cate
        $cateItems = CateItem::where('category_id', '=', $request->id_cate)->get();
        //trả về json
        return response()->json($cateItems);
    }
}
