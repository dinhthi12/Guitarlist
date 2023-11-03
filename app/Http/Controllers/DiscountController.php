<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct()
    {
        $allDisc = Discount::all();
        view()->share('allDisc', $allDisc);
    }
    public function index()
    {

        return view('admin.pages.discounts.index');
    }
    public function show()
    {
        $allPro = Product::all();
        return view('admin.pages.discounts.create')->with(compact('allPro'));
    }
    public function showId($id)
    {
        $allPro = Product::all();
        $allDisc = Discount::find($id);
        return view('admin.pages.discounts.edit')->with(compact('allPro', 'allDisc'));
    }
    public function store(Request $request)
    {
        $disc = new Discount();

        $disc->code = $request->code;
        $disc->discount = $request->discount;
        $disc->quantity = $request->quantity;
        $disc->start_time = $request->start_time;
        $disc->end_time = $request->end_time;
        $disc->save();

        toastr()->success('Thành công', 'Thêm mã giảm giá thành công');
        return redirect(route('listDiscount'));
    }
    public function update(Request $request)
    {
        $disc = Discount::find($request->id);

        $disc->code = $request->code;
        $disc->discount = $request->discount;
        $disc->quantity = $request->quantity;
        $disc->start_time = $request->start_time;
        $disc->end_time = $request->end_time;
        $disc->save();

        toastr()->success('Thành công', 'Thêm mã giảm giá thành công');
        return redirect(route('listDiscount'));
    }
    public function destroy($id)
    {
        $disc = Discount::find($id);
        $disc->delete();
        toastr()->success('Thành công', 'Xóa mã giảm giá thành công');
        return redirect(route('listDiscount'));
    }
}
