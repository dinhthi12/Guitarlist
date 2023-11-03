<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Category;
use App\Models\CateItem;
use App\Models\Comment;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Slide;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        //gọi view đăng ký user
        return view('client.pages.users.register');
    }
    public function loginClient(Request $request)
    {
        //kiểm tra login user
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            return redirect()->route('index')->with('success', 'Đăng nhập thành công');
        } else {
            return redirect()->back()->with('error', 'Đăng nhập thất bại!');
        }
    }
    public function manager()
    {   //trả về view thông tin người dùng
        return view('client.pages.manager.index');
    }
    public function edit_profile()
    {
        //trả về view sửa thông tin người dùng
        return view('client.pages.manager.edit');
    }
    public function updateAccount(Request $request)
    {
        //lấy ID của người dùng đang đăng nhập thông qua lớp Auth
        $id = Auth::user()->id;
        //sử dụng ID ở ở trên để tìm và lấy thông tin người dùng từ cơ sở dữ liệu bằng cách sử dụng mô hình User
        $user = User::find($id);
        //kiểm tra xem trường file_upload trong request có giá trị trống (không có tệp được tải lên) hay không
        if ($request->file_upload == '') {
            //Dòng này lấy giá trị của trường image1 từ request làm giá trị cho biến $image. image1 là đường dẫn của ảnh
            $image = $request->input('image1');
        } else if ($request->has('file_upload')) {
            //Dòng này lấy tệp tải lên từ request và gán cho biến $file.
            $file = $request->file_upload;
            //Dòng này lấy tên gốc của tệp tải lên
            $file_name = $file->getClientOriginalName();
            //di chuyển tệp tải lên vào thư mục public/images/users của ứng dụng Laravel
            $file->move(public_path('images/users'), $file_name);
            //Sau khi tệp tải lên đã được di chuyển, biến $image được gán giá trị là tên tệp.
            $image = $file_name;
        }
        //lưu các thay đổi
        $user->image = $image;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();
        //thông báo và trả về route tương ứng
        toastr()->success('Thành công', 'Cập nhật tài khoản thành công');
        return redirect(route('manager'));
    }
    public function user_address()
    {
        // /Dòng này tìm kiếm và lấy danh sách địa chỉ từ cơ sở dữ liệu bằng cách sử dụng mô hình Address.
        //tìm kiếm các bản ghi trong bảng address mà có trường user_id bằng với ID của người dùng đang đăng nhập.
        //Kết quả được lấy về dưới dạng một danh sách các bản ghi.
        $listAdr = Address::where('user_id', '=', Auth::user()->id)->get();
        //Dòng này trả về một view có tên là 'client.pages.manager.address'.
        //Biến listAdr được truyền vào view thông qua phương thức with và sử dụng hàm compact để tạo một mảng chứa biến này.
        return view('client.pages.manager.address')->with(compact('listAdr'));
    }
    public function addAddress(Request $request)
    {
        //Tạo một đối tượng mới của lớp Address, sẽ được sử dụng để tạo một bản ghi mới trong cơ sở dữ liệu
        $address = new Address();
        //Dòng này gán giá trị cho trường user_id trong đối tượng $adr bằng giá trị được gửi từ biểu mẫu web thông qua $request
        $address->user_id = $request->user_id;
        $address->name = $request->name; //tương tự
        $address->phone = $request->phone; //tương tự
        $address->address = $request->address; //tương tự
        $address->status = $request->status; //tương tự
        // Dòng này thực hiện một truy vấn SQL để cập nhật tất cả các bản ghi trong bảng address
        // DB::update('update address set status = ?', [0]);

        $address->save();

        toastr()->success('Thành công', 'Thêm địa chỉ thành công');
        return redirect(route('user_address'));
    }
    public function geteditAddress($id)
    {
        //Dòng này tìm đối tượng Address trong cơ sở dữ liệu dựa trên giá trị ID của địa chỉ cần chỉnh sửa.
        //Kết quả tìm được sẽ được lưu trong biến $address.
        $address = Address::find($id);
        return view('client.pages.manager.editaddress', ['adr' => $address]);
    }
    public function editAddress(Request $request)
    {
        //Dòng này tìm đối tượng Address trong cơ sở dữ liệu dựa trên giá trị ID của địa chỉ cần chỉnh sửa
        //được trích xuất từ dữ liệu gửi lên qua $request.
        $address = Address::find($request->id);
        $address->user_id = $request->user_id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->status = $request->status;

        $address->save();

        toastr()->success('Thành công', 'Chỉnh sửa địa chỉ thành công');
        return redirect(route('user_address'));
    }
    public function deleteAddress($id)
    {
        $user = Auth::user();

        // Kiểm tra xem người dùng có ít nhất một địa chỉ giao hàng hay không
        if ($user->Address->count() > 1) {
            $address = Address::find($id);
            $address->delete();
            toastr()->success('Thành công', 'Xoá địa chỉ thành công');
        } else {
            toastr()->error('Lỗi', 'Bạn cần có ít nhất một địa chỉ giao hàng');
        }
        return redirect(route('user_address'));
    }
    public function comment($id, Request $request)
    {
        //Dòng này gán giá trị của biến $id từ tham số cho biến $pro_id. xác định sản phẩm mà bình luận sẽ được thêm vào.
        $pro_id = $id;
        // Dòng này tạo một đối tượng mới của lớp Comment để chuẩn bị cho việc lưu bình luận mới vào cơ sở dữ liệu.
        $comment = new Comment();
        //gán giá trị của $pro_id cho thuộc tính pro_id của đối tượng Comment, xác định sản phẩm mà bình luận thuộc về
        $comment->pro_id = $pro_id;
        //Dòng này gán id của người dùng hiện tại (đã đăng nhập) cho thuộc tính user_id của đối tượng Comment, xác định người dùng đã thực hiện bình luận.
        $comment->user_id = Auth::user()->id;
        //: Dòng này gán nội dung bình luận từ request ($request->content) cho thuộc tính content của đối tượng Comment.
        $comment->content = $request->content;
        //òng này kiểm tra xem trường rating_rate trong request có giá trị lớn hơn 0 hay không.
        //Nếu có, nó gán giá trị của rating_rate cho thuộc tính rate của đối tượng Comment.
        //Nếu không, nó đặt rate mặc định là 5.
        if ($request->rating_rate > 0) {
            $comment->rate = $request->rating_rate;
        } else {
            $comment->rate = 5;
        }
        //lưu vào db
        $comment->save();

        return redirect()->back();
    }
    public function orders()
    {
        $orders = Order::where('user_id', '=', Auth::id())->orderBy('id', 'desc')->get();
        return view('client.pages.carts.order', compact('orders'));
    }
    public function discountCode(Request $request)
    {
        $today = Carbon::today();
        $data = $request->discountCode;
        // dd($data);
        $coupon = Discount::where('code', '=', $data)->where('quantity', '>', 0)->whereDate('start_time', '<', $today)->whereDate('end_time', '>', $today)->first();

        if ($coupon) {
            $coupon_session = Session::get('coupon');
            $cou[] = array(
                'code' => $coupon->code,
                'quantity' => $coupon->quantity,
                'discount' => $coupon->discount,
            );
            Session::put('coupon', $cou);
            Session::save();
            $coupon->quantity = $coupon->quantity - 1;
            $coupon->save();
            return redirect()->back()->with('success', 'Áp dụng mã giảm giá thành công');
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không đúng hoặc hết hạn');
        }
    }
    public function orderdetails($id)
    {
        $order = Order::find($id);
        $details = OrderDetail::where('order_id', '=', $id)->get();
        return view('client.pages.carts.orderdetail', compact('order', 'details'));
    }
    public function cancelOrders($id)
    {
        $order = Order::find($id);
        $order->status = 4;
        $order->save();
        return redirect()->back()->with('success', 'Hủy đơn hàng thành công');
    }
}
