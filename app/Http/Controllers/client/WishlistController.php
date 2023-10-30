<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        //thực hiện truy vấn toàn bộ dữ liệu từ bảng Category trong cơ sở dữ liệu và lưu trữ chúng trong biến $allCate
        $allCate = Category::all();
        //sử dụng view()->share() để chia sẻ dữ liệu $allCate với tất cả các view
        //có thể truy cập biến $allCate trong mọi view mà không cần truyền biến này qua các hàm return view()
        view()->share('allCate', $allCate);
    }
    //func xem danh sách sp yêu thích của user
    public function index()
    {
        // /trả về một object đại diện cho người dùng đã đăng nhập.
        $user = Auth::user();
        //Dòng này thực hiện một truy vấn để lấy danh sách yêu thích của người dùng.
        //kiểm tra trong bảng Wishlist các dòng có cột user_id bằng với id của người dùng đang đăng nhập.
        //Kết quả trả về là một danh sách các sản phẩm yêu thích
        $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->paginate(4);
        //trả về view và biến wishlist
        return view('client.pages.wishlist.index', compact('wishlist'));
    }
    public function add($pro_id)
    {
        // Kiểm tra xem người dùng đã thêm sản phẩm này vào danh sách yêu thích chưa
        $pro_wish = Wishlist::where('pro_id', '=', $pro_id,)->where('user_id', '=', Auth::id())->first();
        //nếu tồn tại thì thông báo
        if ($pro_wish) {
            toastr()->info('Sản phẩm này đã có trong danh sách yêu thích của bạn.');
        } else {
            // Tạo một bản ghi mới trong danh sách yêu thích
            Wishlist::create([
                'user_id' => Auth::id(),
                'pro_id' => $pro_id
            ]);
            //thông báo thành công
            toastr()->success('Đã thêm vào danh sách yêu thích.');
        }
        //trả về trang index
        return redirect(route('index'));
    }
    public function delete($id)
    {
        //nhận id là tham số truyền vào gắn object tương ứng vào biện wishlist
        $wishlist = Wishlist::find($id);
        //thực hiện xoá
        $wishlist->delete();
        //trả về route và hiện thông báo
        toastr()->success('Đã xóa sản phẩm khỏi yêu thích.');
        return redirect(route('listWish'));
    }
}
