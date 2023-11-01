<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        //Dòng này truy vấn tất cả các bình luận từ bảng comments trong cơ sở dữ liệu và lưu chúng trong biến $allCom.
        //Biến này chứa danh sách tất cả các bình luận.
        $allCom = Comment::all();
        //tương tự
        $allPro = Product::all();
         //tương tự
        $allUser = User::all();
        $allCom1 = Comment::all();
        return view('admin.pages.comments.index')->with(compact('allPro', 'allUser','allCom', 'allCom1'));
    }
    public function destroy($id)
    {
        $com = Comment::find($id);
        $com->delete();
        toastr()->success('Thành công', 'Xóa bình luận thành công');
        return redirect(route('listCom'));
    }
    public function searchName()
    {
        $keywords = $_GET['keywords_pro_id'];
        $allPro=Product::all();
        $allUser=User::all();
        $allCom = Comment::where('pro_id','=', $keywords)->get();
        $allCom1 = Comment::all();

        if(count($allCom)!=0){
            $cate1 = Product::where('id','=', $keywords)->select('name')->get();
            $sub1 = subStr($cate1, 10);
            $str1 = strrev($sub1);
            $sub2 = subStr($str1, 3);
            $str2 = strrev($sub2);
            $mess = 'Lọc theo tên: '.$str2;
            return view('admin.pages.comments.index')->with(compact('allPro', 'allCom','allCom1', 'allUser','mess'));
        }else{
            $allCom=Comment::all();
            $mess = 'Hiển thị tất cả bình luận';
            return view('admin.pages.comments.index')->with(compact('allPro', 'allCom','allCom1', 'allUser', 'mess'));
        }
    }

    public function searchDate()
    {
        $keywords = $_GET['keywords_date'];
        $allPro=Product::all();
        $allUser=User::all();
        $allCom1 = Comment::all();
        $allCom = Comment::where('created_at','=', $keywords)->get();

        if(count($allCom)!=0){
            $mess = 'Kết quả của từ khóa: '.$keywords;
            return view('admin.pages.comments.index')->with(compact('allPro', 'allCom1', 'allCom', 'allUser', 'mess'));
        }else{
            $allCom=Comment::all();
            $mess = 'Hiển thị tất cả bình luận';
            return view('admin.pages.comments.index')->with(compact('allPro', 'allCom1', 'allCom','allUser', 'mess'));
        }
    }
}
