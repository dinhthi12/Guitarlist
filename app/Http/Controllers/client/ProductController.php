<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CateItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        //thực hiện truy vấn toàn bộ dữ liệu từ bảng Category trong cơ sở dữ liệu và lưu trữ chúng trong biến $allCate
        $allCate = Category::all();
        //sử dụng view()->share() để chia sẻ dữ liệu $allCate với tất cả các view
        //có thể truy cập biến $allCate trong mọi view mà không cần truyền biến này qua các hàm return view()
        view()->share('allCate', $allCate);
    }
    //func xem chi tiết sản phẩm
    public function getProById($id)
    {
        // Sử dụng Eloquent ORM để tìm kiếm sản phẩm dựa trên ID vừa truyền vào.
        // kết quả sẽ được gán vào biến $pro.
        $pro = Product::find($id);
        //Tăng view lên sau mỗi lần click vào sản phẩm
        $pro->view = $pro->view + 1;
        //lưu lại vào db
        $pro->save();
        //lấy detail
        $proDetails = Product::find($id)->Detail;
        //lấy color
        $proColors = Product::find($id)->Color;
        //lấy biến thể
        $proVariant = Product::find($id)->Variant;
        //trả về view cùng mảng giá trị
        return view(
            'client.pages.products.index',
            ['pro' => $pro, 'detail' => $proDetails, 'color' => $proColors, 'variant' => $proVariant]
        );
    }
    public function search()
    {
        $cti_bar = Category::all();
        $keywords = $_GET['keywords'];
        $listPro = Product::where('name', 'LIKE', '%' . $keywords . '%')->orWhere('detail', 'LIKE', '%' . $keywords . '%')->paginate(10);
        //dd($listPro);
        if (count($listPro) == 0) {

            $MesSearch = 'Không tìm thấy kết quả của từ khóa: ' . $keywords . '.';
            return view('client.pages.categories.index')->with(compact('listPro', 'cti_bar', 'keywords', 'MesSearch'));
        } else {
            $MesSearch = 'Kết quả của từ khóa: ' . $keywords . '.';
            return view('client.pages.categories.index')->with(compact('listPro', 'cti_bar', 'keywords', 'MesSearch'));
        }
    }
}
