<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function __construct()
    {
        //thực hiện truy vấn toàn bộ dữ liệu từ bảng Category trong cơ sở dữ liệu và lưu trữ chúng trong biến $allCate
        $allCate = Category::all();
        //sử dụng view()->share() để chia sẻ dữ liệu $allCate với tất cả các view
        //có thể truy cập biến $allCate trong mọi view mà không cần truyền biến này qua các hàm return view()
        view()->share('allCate', $allCate);
    }
    public function contact()
    {
        // Dòng này kiểm tra xem người dùng đã đăng nhập hay chưa. Sử dụng hàm Auth::user()
        //để lấy thông tin người dùng hiện tại và kiểm tra xem trường id của người dùng có tồn tại hay không.
        if (isset(Auth::user()->id)) {
            //Nếu người dùng đã đăng nhập, thông tin người dùng hiện tại sẽ được lấy ra và gán cho biến $dataUser.
            $dataUser = Auth::user();
            //Nếu người dùng đã đăng nhập, dòng này truy vấn cơ sở dữ liệu để lấy danh sách các liên hệ của người dùng hiện tại.
            //Điều này được thực hiện bằng cách sử dụng mô hình Contact và hàm where để lọc ra các liên hệ có user_id trùng với ID của người dùng hiện tại.
            //Kết quả truy vấn này được lưu trong biến $viewContacts.
            $viewContacts = Contact::where('user_id', '=', $dataUser->id)->get();
            //, dòng này trả về một trang giao diện cho người dùng với tên 'contacts.index' và truyền vào đó dữ liệu từ biến $dataUser và $viewContacts.
            //Điều này cho phép giao diện hiển thị thông tin người dùng và danh sách các liên hệ của họ (nếu có).
            return view('client.pages.contacts.index')->with(compact('dataUser', 'viewContacts'));
        } else {
            $dataUser = Auth::user();
            //Đoạn này xử lý trường hợp người dùng chưa đăng nhập.
            return view('client.pages.contacts.index')->with(compact('dataUser'));
        }
    }
    public function addContact(Request $request)
    {
        //Đoạn này tạo một đối tượng mới của mô hình Contact, sẽ được sử dụng để tạo một bản ghi liên hệ mới.
        $contacts = new Contact();
        // Nếu người dùng đã đăng nhập, user_id của liên hệ sẽ được gán bằng id của người dùng đó.
        $contacts->user_id = Auth::user()->id;
        $contacts->user_name = Auth::user()->name; //tương tự
        $contacts->user_email = Auth::user()->email; //tương tự
        $contacts->message = $request->message;

        $contacts->save();
        toastr()->success('Thành công', 'Bạn đã gửi thành công');
        return back();
    }
    public function deleteContact($id)
    {
        //Dòng này tìm đối tượng Contact trong cơ sở dữ liệu dựa trên giá trị ID đã được truyền vào qua tham số $id.
        //trả về đối tượng địa chỉ cụ thể mà bạn muốn xoá.
        $contacts = Contact::find($id);
        $contacts->delete();
        toastr()->success('Thành công', 'Đã xóa tin nhắn liên hệ');
        return back();
    }
}
