<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Dòng này truy vấn tất cả các liên hệ từ bảng contacts trong cơ sở dữ liệu và lưu chúng trong biến $allUser.
        //Biến này chứa danh sách tất cả các liên hệ.
        $allUser = Contact::all();
        //Tương tự như dòng trước,
        $allContact = Contact::all();
        // Dòng này trả về view có tên là index trong thư mục admin.pages.contacts.
        // Đồng thời, bạn truyền biến $allUser và $allContact vào view để hiển thị danh sách các liên hệ trong giao diện quản trị.
        return view('admin.pages.contacts.index')->with(compact('allUser', 'allContact'));
    }
    public function searchContact()
    {
        //$keywords = $_GET['keywords'];:Dòng này lấy từ khóa tìm kiếm từ tham số
        //keywords: được gửi trong URL bằng phương thức GET. Điều này có nghĩa là người dùng nhập từ khóa tìm kiếm trong trình duyệt và gửi nó qua URL.
        $keywords = $_GET['keywords'];
        //Dòng này truy vấn trong cơ sở dữ liệu để tìm các bản ghi trong bảng contacts mà có trường user_name hoặc user_email chứa từ khóa tìm kiếm ($keywords).
        //LIKE được sử dụng để thực hiện tìm kiếm theo mẫu với % đại diện cho bất kỳ chuỗi ký tự nào.
        //Dữ liệu kết quả trả về lưu trong biến $allContact.
        $allContact = Contact::where('user_name', 'LIKE', '%' . $keywords . '%')
            ->orWhere('user_email', 'LIKE', '%' . $keywords . '%')->get();
        // Dòng này kiểm tra xem có kết quả tìm kiếm nào không.
        //Nếu biến $allContact chứa ít nhất một bản ghi (có tổng số lớn hơn 0), nghĩa là tìm thấy kết quả,
        //thì biến $mess sẽ được gán giá trị "Kết quả của từ khóa: ..." và trả về view index với kết quả tìm kiếm.
        if (count($allContact) != 0) {
            $mess = 'Kết quả của từ khóa: ' . $keywords;
            return view('admin.pages.contacts.index')->with(compact('allContact', 'mess'));
        //Dòng này kiểm tra xem từ khóa keywords có giá trị null hay không.
        //Nếu có, nghĩa là người dùng không nhập từ khóa tìm kiếm, và biến $mess sẽ được gán giá trị "Tất cả tin nhắn liên hệ".
        //Trang web sẽ hiển thị tất cả các liên hệ.
        } else if ($keywords == null) {
            $allContact = Contact::all();
            $mess = 'Tất cả tin nhắn liên hệ';
            return view('admin.pages.contacts.index')->with(compact('allContact', 'mess'));
        // Trường hợp này xảy ra khi không tìm thấy kết quả và từ khóa không phải null.
        //Biến $mess sẽ được gán giá trị "Không tìm thấy kết quả của từ khóa: ... Hiển thị tất cả".
        //Trang web sẽ hiển thị tất cả các liên hệ và thông báo rằng không tìm thấy kết quả tìm kiếm.
        } else {
            $allContact = Contact::all();
            $mess = 'Không tìm thấy kết quả của từ khóa: ' . $keywords . '. Hiển thị tất cả';
            return view('admin.pages.contacts.index')->with(compact('allContact', 'mess'));
        }
    }
}
