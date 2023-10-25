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
        $allCom = Comment::all();
        view()->share('allCom', $allCom);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPro = Product::all();
        $allUser = User::all();
        $allCom1 = Comment::all();
        return view('admin.pages.comments.index')->with(compact('allPro', 'allCom1', 'allUser'));
    }
    public function destroy($id)
    {
        $com = Comment::find($id);
        $com->delete();
        toastr()->success('Thành công', 'Xóa bình luận thành công');
        return redirect(route('listCom'));
    }
}
