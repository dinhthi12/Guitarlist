<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmationEmail;
use App\Models\Address;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
    public function insertOrder(Request $r)
    {
        // INSERT ORDER
        $order = new Order();
        $order->user_id = $r->user_id;
        $order->address_id = $r->user_address;
        $order->delivery_id = $r->deli_id;
        $order->discount = $r->discount;
        $order->total = $r->total;
        $order->status = 0;
        $order->note = $r->note;
        $order->save();
        $order_id = $order->id;
        // INSERT ORDER_DETAIL
        $allProCart = session()->get('cart');
        foreach ($allProCart as $pro) {
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order_id;
            $order_detail->pro_id = $pro['id'];
            $order_detail->name = $pro['name'];
            $order_detail->number = $pro['qty'];
            $order_detail->price = $pro['price'];
            $order_detail->save();
        }
        session()->forget(['cart', 'coupon']);
        return redirect()->back()->with('success', 'Tạo đơn hàng thành công');
    }

    public function vnPay_payment(Request $request)
    {
        $data = $request->all();
        $code_cart = rand(00, 9999);
        session(['url_prev' => url()->previous()]);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/";
        $vnp_TmnCode = "2TBKZWKI"; //Mã website tại VNPAY
        $vnp_HashSecret = "ZTSLLNKLUPADKSOYNNFULMEDXFEKKLSP"; //Chuỗi bí mật

        $vnp_TxnRef = $code_cart; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $data['total'] * 100;
        $vnp_Locale = "VN";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        session()->forget(['cart', 'coupon']);
        return redirect($vnp_Url)->with('success', 'Đã thanh toán phí dịch vụ');
        // if($_POST['vnp_ResponseCode'] == "00") {
        //     return redirect($vnp_Url)->with('success' ,'Đã thanh toán phí dịch vụ');
        // }
        // return redirect($vnp_Url)->with('errors' ,'Lỗi trong quá trình thanh toán phí dịch vụ');
    }
}
