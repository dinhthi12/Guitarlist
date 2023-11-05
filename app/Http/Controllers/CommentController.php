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
        //Dòng này tìm kiếm một bản ghi trong bảng "comments" dựa trên giá trị $id được truyền vào hàm
        //Bản ghi được tìm kiếm được lưu trong biến $com.
        $com = Comment::find($id);
        //Dòng này gọi phương thức delete() trên đối tượng $com để xóa bản ghi tương ứng với ID đã được truyền vào.
        //Khi phương thức này được gọi, bản ghi trong cơ sở dữ liệu sẽ bị xóa.
        $com->delete();
        //Hiển thị thông báo
        toastr()->success('Thành công', 'Xóa bình luận thành công');
        //trả về view
        return redirect(route('listCom'));
    }
    public function searchName()
    {
        //Dòng này lấy giá trị của tham số keywords_pro_id từ yêu cầu HTTP GET
        $keywords = $_GET['keywords_pro_id'];
        //Dòng này truy vấn tất cả sản phẩm từ bảng "products" trong cơ sở dữ liệu và lưu kết quả vào biến $allPro
        $allPro=Product::all();
        //tương tự
        $allUser=User::all();
        //tương tự
        $allCom1 = Comment::all();
        //Dòng này truy vấn tất cả các bình luận (comments) trong cơ sở dữ liệu có trường pro_id bằng giá trị $keywords (giá trị được lấy từ tham số URL) và lưu vào biến $allCom.
        $allCom = Comment::where('pro_id','=', $keywords)->get();
        //Dòng này kiểm tra nếu có bình luận được tìm thấy dựa trên tìm kiếm theo pro_id
        if(count($allCom)!=0){
        //Dòng này truy vấn tên của sản phẩm có id bằng giá trị $keywords và lưu vào biến $cate1
            $cate1 = Product::where('id','=', $keywords)->select('name')->get();
        //Dòng này cắt ra một phần của tên sản phẩm lưu trong $cate1, bắt đầu từ ký tự thứ 11 (tính từ 0). Kết quả được lưu vào biến $sub1.
            $sub1 = subStr($cate1, 10);
        // Dòng này đảo ngược chuỗi $sub1 (đảo ngược tên sản phẩm).
            $str1 = strrev($sub1);
        //Dòng này cắt ra một phần của chuỗi đảo ngược $str1, bắt đầu từ ký tự thứ 4 (tính từ 0). Kết quả được lưu vào biến $sub2.
            $sub2 = subStr($str1, 3);
        //Dòng này đảo ngược chuỗi $sub2 để có tên sản phẩm được hiển thị theo đúng thứ tự.
            $str2 = strrev($sub2);
        //Thông báo này bao gồm chuỗi "Lọc theo tên: " và tên sản phẩm được đảo ngược. Thông báo này được lưu trong biến $mess.
            $mess = 'Lọc theo tên: '.$str2;
        // Dòng này trả về một trang web (view) có tên "admin.pages.comments.index" và truyền các biến và thông báo đã tạo (được đóng gói bằng compact) để hiển thị trên trang web.
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
