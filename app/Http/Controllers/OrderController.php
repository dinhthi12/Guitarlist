<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('admin.pages.orders.index', compact('orders'));
    }

    public function update(Request $request)
    {
        $order = Order::find($request->order_id);
        $currentStatus = $order->status;
        $newStatus = $request->status;
        if ($newStatus > $currentStatus) {
            // Thực hiện cập nhật trạng thái
            $order->status = $newStatus;
            $order->save();
            toastr()->success('Chuyển trạng thái thành công.');
            // Xử lý khi chuyển trạng thái thành công
        } else {
            toastr()->error('Không thể chuyển trạng thái ngược lại.');
        }
        return redirect('admin/order/index');
    }
    public function detail($id)
    {
        $order = Order::find($id);
        $details = OrderDetail::where('order_id', '=', $id)->get();
        return view('admin.pages.orders.detail', compact('order', 'details'));
    }
    public function delete($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect('admin/order/index')->with('success', 'Xóa đơn hàng thành công');
    }
    public function orderByStatus(Request $r)
    {
        if($r->status == 5){
            $orders = Order::orderBy('id','desc')->get();
            return view('admin.pages.orders.index', compact('orders'));
        }
        $orders = Order::where('status', '=', $r->status)->orderBy('id','desc')->get();
        return view('admin.pages.orders.index', compact('orders'));
    }
}
