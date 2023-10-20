<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SlideController extends Controller
{
    public function __construct()
    {
        $allSlide = Slide::all();
        view()->share('allSlide', $allSlide);
    }
    public function index()
    {
        $allSlide = Slide::where('slide_status','=',1)->orderBy('id','DESC')->get();
        return view('admin.pages.slides.index');
    }
    public function loadCreate()
    {
        return view('admin.pages.slides.create');
    }
    public function create(Request $r)
    {
        $slide = new Slide();

        if($r->has('file_upload')){
            $file=$r->file_upload;
            $file_name= date('YmdHi').$file->getClientOriginalName();
            //dd($file_name);
            $file->move(public_path('images/slider'),$file_name);
        }
        $r->merge(['image'=>$file_name]);

        $slide->name=$r->name;
        $slide->image=$r->image;
        $slide->slide_status=$r->slide_status;
        $slide->slide_desc=$r->slide_desc;
        $slide->save();
        Session::put('success', 'Thêm slide thành công');
        return redirect(route('listSlide'));

    }
}
