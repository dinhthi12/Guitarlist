<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        //Dòng này kiểm tra xem người dùng đã đăng nhập hay chưa bằng cách sử dụng Auth::check().
        //Nếu người dùng đã đăng nhập, mã trong khối lệnh bên trong sẽ được thực thi.
        if(Auth::check()){
            //Dòng này lấy thông tin của người dùng đã đăng nhập và gán cho biến $user.
            $user=Auth::user();
            //Dòng này kiểm tra vai trò (role) của người dùng, tức là xem người dùng có quyền admin hay không.
            //Trong trường hợp này, nếu role bằng 1, tức là người dùng có quyền admin, mã bên trong khối lệnh sẽ được thực thi.
            if($user->role==1){
                //Nếu người dùng đã đăng nhập và có quyền admin (role là 1),
                //thì request được truyền tới middleware tiếp theo hoặc controller tiếp theo bằng cách gọi $next($request)
                return $next($request);
            }
            else{
                return redirect('adminlogin');
            }
        }
        else{
            return redirect('adminlogin');
        }
    }
}
