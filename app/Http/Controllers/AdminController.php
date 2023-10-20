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
    //gọi view đăng nhập
    public function index(){
        return view("admin.pages.index");
    }

    public function adminLogin(Request $request){
        //lấy data
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        //check data và rule
        if(Auth::attempt($data)){
            return redirect('admin/index')->with('success', 'Đăng nhập thành công');
        }
        else{
            return redirect()->back()->with('error', 'Đăng nhập thất bại!');
        }
    }
}
