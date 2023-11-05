<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    //
    public function __construct()
    {
    }
    //gọi view đăng nhập
    public function index(){
        $totalView = Product::sum('view');
        $revenue= Order::sum('total');
        $orders= Order::count();
        $totalPro= OrderDetail::sum('number');
        $date = Carbon::now();
        $orders = Order::where('status', '=', 0)->orderBy('id','desc')->limit('5')->get();
        $cate= Category::all();
        $chartPro=[];
        foreach ($cate as $key =>$c){
            $qty= $c->Product->sum('quantity');
            $name=$c->name;
            $chartPro[++$key]=[$name, $qty];
        }
        // $higest_resolved=DB::select(DB::raw('SELECT product_id,SUM(number) as number_total,product_name
        // FROM order_details GROUP by product_id ORDER by number_total DESC'));
        return view('admin.pages.index', compact('totalView','revenue','orders','totalPro','date', 'chartPro'));
    }

    public function adminLogin(Request $request){
        //lấy data
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($data)){
            // Kiểm tra xem người dùng có phải là admin không
            $user = Auth::user();
            if($user->role === 1){
                return redirect('admin/index')->with('success', 'Đăng nhập thành công');
            } else {
                Auth::logout(); // Đăng xuất người dùng nếu họ không phải là admin
                return redirect()->back()->with('error', 'Đăng nhập thất bại!');
            }
        }
        else{
            return redirect()->back()->with('error', 'Đăng nhập thất bại!');
        }
    }
}
