<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CateItem;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    use AuthenticatesUsers;
    //hàm khởi tạo của một controller Laravel. Nó sẽ được thực hiện mỗi khi controller này được gọi
    public function __construct()
    {
        //thực hiện truy vấn toàn bộ dữ liệu từ bảng Category trong cơ sở dữ liệu và lưu trữ chúng trong biến $allCate
        $allCate = Category::all();
        //sử dụng view()->share() để chia sẻ dữ liệu $allCate với tất cả các view
        //có thể truy cập biến $allCate trong mọi view mà không cần truyền biến này qua các hàm return view()
        view()->share('allCate', $allCate);

        //truy vấn toàn bộ dữ liệu từ bảng Slide trong cơ sở dữ liệu trong đó cột slide_status có giá trị là 1,
        //và sắp xếp chúng theo cột id theo thứ tự giảm dần (để lấy các slide mới nhất).
        $allSlide = Slide::where('slide_status', '=', 1)->orderBy('id', 'DESC')->get();
        view()->share('allSlide', $allSlide);

        // $slide = Slide::orderBy('id','DESC')->where('slide_status',1)->take(3)->get();
        // view()->share('slider', $slide);
    }
    public function index()
    {
        //$homeTopPr: Dòng này truy vấn dữ liệu sản phẩm hot (được xác định bởi hot=1) và giới hạn số lượng kết quả là 4
        $homeTopPr = Product::where('hot', '=', '1')->limit(4)->get();
        //$homeNewPr: Dòng này truy vấn toàn bộ sản phẩm, sắp xếp theo id theo thứ tự giảm dần (lấy sản phẩm mới nhất) và giới hạn số lượng kết quả là 5.
        $homeNewPr = Product::orderBy('id', 'desc')->limit(5)->get();
        //$homeSalePr: Dòng này truy vấn toàn bộ sản phẩm, sắp xếp theo giảm dần của giảm giá (discount) và giới hạn số lượng kết quả là 8.
        $homeSalePr = Product::orderBy('discount', 'desc')->limit(8)->get();
        //Dòng này trả về view với tên 'client.pages.index' và chuyển dữ liệu từ ba biến $homeTopPr, $homeNewPr, và $homeSalePr tới view. Các biến này sẽ sẵn có trong trang chính (index) để hiển thị dữ liệu.
        return view('client.pages.index', ['homeTopPr' => $homeTopPr, 'homeNewPr' => $homeNewPr, 'homeSalePr' => $homeSalePr]);
    }
    public function signup()
    {
        return view('client.pages.users.register');
    }
    public function loginClient(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            return redirect()->back()->with('success', 'Đăng nhập thành công');
        } else {
            return redirect()->back()->with('error', 'Đăng nhập thất bại!');
        }
    }
}
