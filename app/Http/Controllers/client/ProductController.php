<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CateItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        //tổng số bình luận
        $countTotal = DB::table('comment')->where('pro_id', '=', $pro->id)->count();
        //tổng số bình luận 5*
        $count5 = DB::table('comment')->where('pro_id', '=', $pro->id)->where('rate', '=', 5)->count();
        //tổng số bình luận 4*
        $count4 = DB::table('comment')->where('pro_id', '=', $pro->id)->where('rate', '=', 4)->count();
        //tổng số bình luận 3*
        $count3 = DB::table('comment')->where('pro_id', '=', $pro->id)->where('rate', '=', 3)->count();
        //tổng số bình luận 2*
        $count2 = DB::table('comment')->where('pro_id', '=', $pro->id)->where('rate', '=', 2)->count();
        //tổng số bình luận 1*
        $count1 = DB::table('comment')->where('pro_id', '=', $pro->id)->where('rate', '=', 1)->count();

        //nếu countTotal > 0
        if ($countTotal > 0) {
            //tính tổng thể
            $tong = ($count5 * 5 + $count4 * 4 + $count3 * 3 + $count2 * 2 + $count1 * 1) / $countTotal;
            //làm tròn số
            $Round =  round($tong, 1);
            //nối bảng + gắn giá trị tương ứng và hiển thị ra view
            $comm = DB::table('comment')->join('user', 'user.id', '=', 'comment.user_id')->select('comment.*', 'user.name')->where('pro_id', '=', $pro->id)->get();
            //trả về view cùng mảng giá trị
            return view(
                'client.pages.products.index',
                [
                    'pro' => $pro,
                    'detail' => $proDetails,
                    'color' => $proColors,
                    'variant' => $proVariant,
                    'comm' => $comm,
                    'countTotal' => $countTotal,
                    'count5' => $count5,
                    'count4' => $count4,
                    'count3' => $count3,
                    'count2' => $count2,
                    'count1' => $count1,
                    'Round' => $Round
                ]
            );
        } else {
            //tương tự
            $comm = DB::table('comment')->join('user', 'user.id', '=', 'comment.user_id')->select('comment.*', 'user.name')->where('pro_id', '=', $pro->id)->get();
            //trả về view cùng mảng giá trị
            return view(
                'client.pages.products.index',
                [
                    'pro' => $pro,
                    'detail' => $proDetails,
                    'color' => $proColors,
                    'variant' => $proVariant,
                    'comm' => $comm,
                    'countTotal' => $countTotal,
                    'count5' => $count5,
                    'count4' => $count4,
                    'count3' => $count3,
                    'count2' => $count2,
                    'count1' => $count1
                ]
            );
        }
    }
    public function search(Request $request)
    {
        $cti_bar = Category::all();
        //Dòng này lấy từ khóa tìm kiếm từ tham số URL với tên keywords.
        //Nó sử dụng biến siêu toàn cục $_GET để truy cập giá trị từ URL.
        $keywords = $request->input('keywords');

        //Dòng này truy vấn các sản phẩm từ mô hình Product dựa trên từ khóa tìm kiếm.
        //nó sử dụng phương thức where để tìm các sản phẩm có tên hoặc mô tả chứa từ khóa (sử dụng điều kiện LIKE),
        //sau đó sử dụng orWhere để kết hợp các điều kiện.
        //Kết quả được phân trang với mỗi trang chứa tối đa 9 kết quả.
        $listPro = Product::where('name', 'LIKE', '%' . $keywords . '%')->orWhere('detail', 'LIKE', '%' . $keywords . '%')->paginate(9);
        //dd($listPro);
        //Dòng này kiểm tra xem có kết quả tìm kiếm nào không.
        //Nếu số lượng kết quả bằng 0 (không tìm thấy sản phẩm nào), thông báo tương ứng được gán vào biến $MesSearch.
        if (count($listPro) == 0) {
            $MesSearch = 'Không tìm thấy kết quả của từ khóa: ' . $keywords;
            return view('client.pages.categories.index')->with(compact('listPro', 'cti_bar', 'keywords', 'MesSearch'));
        } else {
            $MesSearch = 'Kết quả của từ khóa: ' . $keywords;
            return view('client.pages.categories.index')->with(compact('listPro', 'cti_bar', 'keywords', 'MesSearch'));
        }
    }
}
