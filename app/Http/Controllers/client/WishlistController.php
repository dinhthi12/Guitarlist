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
    public function wishlist()
    {

        $user = Auth::user();
        $wishlist = $user->wishlist;
        $wishlist1 = Wishlist::where('user_id','=', Auth::user()->id)->get();
        return view('client.pages.wishlist.index', compact('wishlist1'));
    }
    public function add($pro_id)
    {
        $pro_wish = Wishlist::where('pro_id', '=', $pro_id,)->where('user_id', '=', Auth::id())->first();
        if ($pro_wish) {
            toastr()->success('Thành công', 'Thêm vào yêu thích thành công');
            return redirect(route('listWish'));
        } else {
            Wishlist::insert([
                'user_id' => Auth::id(),
                'pro_id' => $pro_id
            ]);
        }
        toastr()->success('Thành công', 'Thêm vào yêu thích thành công');
        return redirect(route('listWish'));
    }
}
