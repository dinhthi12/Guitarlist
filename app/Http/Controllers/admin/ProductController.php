<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CateItem;
use App\Models\Color;
use App\Models\Detail;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function __construct()
    {
    }
    public function index()
    {
        $allPro = Product::paginate(5);
        return view('admin.pages.products.index', compact('allPro', 'allPro'));
    }

    public function createView()
    {
        $allCate = Category::all();
        return view('admin.pages.products.create', compact('allCate'));
    }
    public function loadCateItem(Request $request)
    {
        $allCateItems = CateItem::where('category_id', $request->id_cate)->get();
        return response()->json($allCateItems);
    }

    public function create(Request $r)
    {

        $pro = new Product();

        if ($r->has('file_upload')) {
            $file = $r->file_upload;
            $file_name = date('YmdHi') . $file->getClientOriginalName();
            // dd($file_name);
            $file->move(public_path('images/products'), $file_name);
        }
        $r->merge(['image' => $file_name]);

        $pro->name = $r->name;
        $pro->cateitem_id = $r->category_id;
        $pro->price = $r->price;
        $pro->discount = $r->discount;
        $pro->image = $r->image;
        $pro->quantity = $r->quantity;
        $pro->detail = $r->detail;
        $pro->hot = $r->hot;
        $pro->status = $r->status;
        $pro->save();
        $id_pro = $pro->id;

        if (isset($r->mechanicalSet)) {
            $pro_details = new Detail();
            $pro_details->pro_id = $id_pro;
            $pro_details->mechanicalSet = $r->mechanicalSet;
            $pro_details->soundboard = $r->soundboard;
            $pro_details->keyboard = $r->keyboard;
            $pro_details->size = $r->size;
            $pro_details->weight = $r->weight;
            $pro_details->manufacture = $r->manufacture;
            $pro_details->save();
        }
        return redirect('admin/products/index')->with('success', 'Thêm sản phẩm thành công');
    }
    public static function delete($id)
    {
        $pro = Product::find($id);
        $pro->delete();
        return redirect('admin/products/index')->with('success', 'Thêm sản phẩm thành công');
    }

    public function loadEdit($id)
    {
        $pro = Product::find($id);
        $pro_details = Product::find($id)->ProDetails;
        $allCate = Category::all();
        $allCateItems = CateItem::all();
        return view('admin.pages.products.edit')->with(compact('pro', 'allCate', 'pro_details', 'allCateItems'));
    }

    public function edit(Request $r)
    {
        $pro = Product::find($r->id);

        if ($r->file_upload == '') {
            $image = $r->input('image1');
        } else if ($r->has('file_upload')) {
            $file = $r->file_upload;
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/products'), $file_name);
            $image = $file_name;
        }

        $pro->name = $r->name;
        $pro->cateitem_id = $r->category_id;
        $pro->price = $r->price;
        $pro->discount = $r->discount;
        $pro->image = $image;
        $pro->quantity = $r->quantity;
        $pro->detail = $r->detail;
        $pro->hot = $r->hot;
        $pro->status = $r->status;
        $pro->save();

        if (isset($r->mechanicalSet)) {
            $pro_details = Detail::where('pro_id', '=', $pro->id)->first();

            if ($pro_details) {
                $pro_details->pro_id = $pro->id;
                $pro_details->mechanicalSet = $r->mechanicalSet;
                $pro_details->soundboard = $r->soundboard;
                $pro_details->keyboard = $r->keyboard;
                $pro_details->size = $r->size;
                $pro_details->weight = $r->weight;
                $pro_details->manufacture = $r->manufacture;
                $pro_details->save();
            }else{
                $pro_details= new Detail();
                $pro_details->pro_id=$pro->id;
                $pro_details->mechanicalSet = $r->mechanicalSet;
                $pro_details->soundboard = $r->soundboard;
                $pro_details->keyboard = $r->keyboard;
                $pro_details->size = $r->size;
                $pro_details->weight = $r->weight;
                $pro_details->manufacture = $r->manufacture;
                $pro_details->save();
            }
        }
        toastr()->success('Thành công', 'Cập nhật sản phẩm thành công');
        return redirect(route('listPro'));
    }

    public function showVariants($id)
    {
        $pro=Product::find($id);
        $allCate=Category::all();
        $pro_color=Color::where('pro_id','=',$id)->get();
        // dd($pro_color);
        $pro_memory=Variant::where('pro_id','=',$id)->get();
        return view('admin.pages.products.variants')->with(compact('pro','allCate','pro_color','pro_memory'));
    }

    public function createColor(Request $r)
    {
        $pro_color= new Color();
        if($r->has('file_image_color')){
            $file=$r->file_image_color;
            $file_image_color= date('YmdHi').$file->getClientOriginalName();
            //dd($file_name);
            $file->move(public_path('images/products'),$file_image_color);
        }
        $r->merge(['image_color'=>$file_image_color]);

        $pro_color->pro_id=$r->id;
        $pro_color->color=$r->color;
        $pro_color->image=$file_image_color;
        $pro_color->price=$r->price_color;
        $pro_color->save();

        toastr()->success('Thành công', 'Thêm biến thể thành công');
        return back();
    }

    public function createMemory(Request $r)
    {
        $pro_memory= new Variant();
        $pro_memory->pro_id=$r->id;
        $pro_memory->name=$r->name;
        $pro_memory->eq=$r->eq;
        $pro_memory->price=$r->price_memory;
        $pro_memory->save();

        toastr()->success('Thành công', 'Thêm biến thể thành công');
        return back();
    }
}
