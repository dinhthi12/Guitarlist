<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //View client
        $allCom = Comment::all();
        $allPro = Product::all();
        $allUser = User::where('role', '=', 0)->get();
        return view('admin.pages.users.index')->with(compact('allPro', 'allUser', 'allCom'));
    }

    public function indexAdmin()
    {
        //View client
        $allCom = Comment::all();
        $allPro = Product::all();
        $allUser = User::where('role', '=', 1)->get();
        return view('admin.pages.users.indexAdmin')->with(compact('allPro', 'allUser', 'allCom'));
    }

    public function searchNameUser()
    {
        //View client
        $keywords = $_GET['keywords'];
        $allCom = Comment::all();
        $allPro = Product::all();
        $allUser = User::when($keywords, function ($query, $keywords) {
            $query->where('email', 'LIKE', '%' . $keywords . '%')->orWhere('name', 'LIKE', '%' . $keywords . '%');
        })->where('role', '=', 0)->get();

        if ((count($allUser) != 0)) {
            $message = 'Kết quả của: ' . $keywords;
            return view('admin.pages.users.index')->with(compact('allPro', 'allUser', 'allCom', 'message'));
        } else {
            $message = 'Không tìm thấy kết quả của: ' . $keywords;
            return view('admin.pages.users.index')->with(compact('allPro', 'allUser', 'allCom', 'message'));
        }
    }
    public function searchNameAdmin()
    {
        //View client
        $keywords = $_GET['keywords'];
        $allCom = Comment::all();
        $allPro = Product::all();
        $allUser = User::when($keywords, function ($query, $keywords) {
            $query->where('email', 'LIKE', '%' . $keywords . '%')->orWhere('name', 'LIKE', '%' . $keywords . '%');
        })->where('role', '=', 1)->get();

        if ((count($allUser) != 0)) {
            $message = 'Kết quả của: ' . $keywords;
            return view('admin.pages.users.indexAdmin')->with(compact('allPro', 'allUser', 'allCom', 'message'));
        } else {
            $message = 'Không tìm thấy kết quả của: ' . $keywords;
            return view('admin.pages.users.indexAdmin')->with(compact('allPro', 'allUser', 'allCom', 'message'));
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        toastr()->success('Thành công', 'Xóa người dùng thành công');
        return back();
    }
}
