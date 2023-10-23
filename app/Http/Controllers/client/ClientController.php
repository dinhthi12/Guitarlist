<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Category;
use App\Models\CateItem;
use App\Models\Product;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //check login user
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
        $id = Auth::user()->id;
        $user = User::find($id);
        if ($request->file_upload == '') {
            $image = $request->input('image1');
        } else if ($request->has('file_upload')) {
            $file = $request->file_upload;
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/users'), $file_name);
            $image = $file_name;
        }
        $user->image = $image;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();
        toastr()->success('Thành công', 'Cập nhật tài khoản thành công');
        return redirect(route('manager'));
    }
    public function user_address()
    {
        Auth::user()->id;
        $listAdr = Address::where('user_id', '=', Auth::user()->id)->get();
        return view('client.pages.manager.address')->with(compact('listAdr'));
    }
    public function addAddress(Request $r)
    {
        $adr = new Address();
        $adr->user_id = $r->user_id;
        $adr->name = $r->name;
        $adr->phone = $r->phone;
        $adr->address = $r->address;
        $adr->status = $r->status;
        DB::update('update address set status = ?', [0]);

        $adr->save();

        toastr()->success('Thành công', 'Thêm địa chỉ thành công');
        return redirect(route('user_address'));
    }
    public function geteditAddress($id)
    {
        $adr = Address::find($id);

        return view('client.pages.manager.editaddress', ['adr' => $adr]);
    }
    public function editAddress(Request $r)
    {
        $adr = Address::find($r->id);
        $adr->user_id = $r->user_id;
        $adr->name = $r->name;
        $adr->phone = $r->phone;
        $adr->address = $r->address;

        $adr->status = $r->status;

        $adr->save();

        toastr()->success('Thành công', 'Chỉnh sửa địa chỉ thành công');
        return redirect(route('user_address'));
    }
    public function deleteAddress($id)
    {
        $adr = Address::find($id);
        // $id = $adr->id;
        $adr->delete();
        toastr()->success('Thành công', 'Xoá địa chỉ thành công');
        return redirect(route('user_address'));
    }
}
