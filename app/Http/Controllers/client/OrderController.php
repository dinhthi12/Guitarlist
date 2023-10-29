<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Category;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        //thực hiện truy vấn toàn bộ dữ liệu từ bảng Category trong cơ sở dữ liệu và lưu trữ chúng trong biến $allCate
        $allCate = Category::all();
        //sử dụng view()->share() để chia sẻ dữ liệu $allCate với tất cả các view
        //có thể truy cập biến $allCate trong mọi view mà không cần truyền biến này qua các hàm return view()
        view()->share('allCate', $allCate);
    }
    public function viewCart()
    {
        if (Auth::check()) {
            $userAddress = Address::where('user_id', '=', Auth::user()->id)->get();
            view()->share('userAddress', $userAddress);
        }
        $allProCart = session()->get('cart');
        $delivery = Delivery::all();
        return view('client.pages.carts.index')->with(compact('allProCart', 'delivery'));
    }
    public function addCart(Request $request)
    {
        $pro_id = $request->pro_id;
        $name = $request->name;
        $image = $request->image;
        $price = $request->price;
        $qty = $request->qty;

        $cart = session()->get('cart', []);
        if (isset($cart[$name])) {
            $cart[$name] = [
                'id' => $pro_id,
                'name' => $name,
                'image' => $image,
                'price' => $price,
                'qty' => $cart[$name]['qty'] += $qty,
                'total' => $cart[$name]['qty'] * $cart[$name]['price']
            ];
        } else {
            $cart[$name] = [
                'id' => $pro_id,
                'name' => $name,
                'image' => $image,
                'price' => $price,
                'qty' => $qty,
                'total' => $price * $qty
            ];
        }
        session()->put('cart', $cart);
        $cart = session()->get('cart', []);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }
    public function deleteItemCart($name)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$name])) {
            unset($cart[$name]);
            session()->put('cart', $cart);
        }
        $allProCart = session()->get('cart');
        toastr()->success('Thành công', 'Đã xóa sản phẩm khỏi giỏ hàng');
        return redirect()->back();
    }
}
