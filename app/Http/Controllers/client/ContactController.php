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
        if (isset(Auth::user()->id)) {
            $dataUser = Auth::user();
            $viewContacts = Contact::where('user_id', '=', $dataUser->id)->get();
            return view('client.pages.contacts.index')->with(compact('dataUser', 'viewContacts'));
        } else {
            $dataUser = Auth::user();
            return view('client.pages.contacts.index')->with(compact('dataUser'));
        }
    }
    public function addcontact(Request $request)
    {
        $contacts = new Contact();
        if (isset(Auth::user()->id)) {
            $contacts->user_id = Auth::user()->id;
            $contacts->user_name = Auth::user()->name;
            $contacts->user_email = Auth::user()->email;
            $contacts->message = $request->message;
        } else {
            $contacts->user_id = 0;
            $contacts->user_name = $request->name;
            $contacts->user_email = $request->email;
            $contacts->message = $request->message;
        }
        $contacts->save();
        $dataUser = Auth::user();
        toastr()->success('Thành công', 'Bạn đã gửi thành công');
        return back();
    }
    public function deletecontact($id)
    {

        $contacts = Contact::find($id);
        $contacts->delete();
        toastr()->success('Thành công', 'Đã xóa tin nhắn liên hệ');
        return back();
    }
}
