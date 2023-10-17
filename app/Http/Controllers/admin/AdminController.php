<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function __construct()
    {

    }
    public function index(){
        return view("admin.pages.index");
    }

    public function adminLogin(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('admin/index')->with('success', 'Đăng nhập thành công');
        }
        else{
            return redirect('adminlogin')->withErrors(['err' => 'Sai tài khoản hoặc mật khẩu']);;
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }
}
