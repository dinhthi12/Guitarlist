<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        //Dòng này truy vấn tất cả dữ liệu từ bảng "delivery" trong cơ sở dữ liệu và lưu vào biến $ListDelivery.
        $ListDelivery = Delivery::all();
        //Dòng này trả về một trang web (view) có tên "admin.pages.deliveries.index" và truyền biến $ListDelivery để hiển thị danh sách giao hàng trên trang web
        return view('admin.pages.deliveries.index', compact('ListDelivery'));
    }

    //Phương thức này được sử dụng để hiển thị trang tạo mới cho phương thức giao hàng.
    public function CreateDelivery()
    {
        return view('admin.pages.deliveries.create');
    }
    public function CreateDelivery_(Request $request)
    {
        //òng này tạo một đối tượng mới của lớp Delivery
        //đây là một cách để tạo một bản ghi mới trong bảng "delivery" trong cơ sở dữ liệu.
        $deli = new Delivery();
        //Dòng này gán giá trị cho thuộc tính "value" của đối tượng Delivery dựa trên dữ liệu được gửi trong biểu mẫu (form) và truyền qua tham số $request.
        $deli->value = $request->value;
        //tương tự
        $deli->name = $request->name;
        // Dòng này lưu đối tượng Delivery vào cơ sở dữ liệu. Điều này tạo một bản ghi mới trong bảng "deliveries" với các thông tin đã được gán.
        $deli->save();
        //trả về view tương ứng + hiện thông báo
        toastr()->success('Thành công', 'Thêm phương thức vận chuyển thành công');
        return redirect(route('ListDelivery'));
    }
    public function getEdit($id)
    {
        $allDeli = Delivery::find($id);
        return view('admin.pages.deliveries.edit')->with(compact('allDeli'));
    }
    public function edit(Request $r)
    {
        $deli = Delivery::find($r->id);
        $deli->value = $r->value;
        $deli->name = $r->name;
        $deli->save();
        toastr()->success('Thành công', 'Chỉnh sửa phương thức vận chuyển thành công');
        return redirect(route('ListDelivery'));
    }
    public function DeleteDelivery($id)
    {
        $deli = Delivery::find($id);
        $deli->delete();
        toastr()->success('Thành công', 'Xóa phương thức vận chuyển thành công');
        return redirect(route('ListDelivery'));
    }
}
