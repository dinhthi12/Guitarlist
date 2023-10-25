<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SlideController extends Controller
{
    //lấy ds slide
    public function __construct()
    {
        $allSlide = Slide::all();
        view()->share('allSlide', $allSlide);
    }
    public function index()
    {
        return view('admin.pages.slides.index');
    }
    public function loadCreate()
    {
        //form slide
        return view('admin.pages.slides.create');
    }
    public function create(Request $request)
    {
        //tạo 1 slide mới
        $slide = new Slide();

        //Đây là một kiểm tra điều kiện để xác định xem biểu mẫu đã gửi một tệp tải lên với tên trường file_upload hay chưa.
        if ($request->has('file_upload')) {
            $file = $request->file_upload;
            $file_name = date('YmdHi') . $file->getClientOriginalName();
            //dd($file_name);
            //i chuyển tệp tải lên đến thư mục công khai (public)
            //có đường dẫn public_path('images/slides') và đặt tên mới cho tệp dựa trên $file_name.
            $file->move(public_path('images/slides'), $file_name);
        }
        //Dòng này gán tên của tệp đã tải lên vào trường image trong dữ liệu yêu cầu ($r).
        $request->merge(['image' => $file_name]);
        //gán dữ liệu
        $slide->name = $request->name;
        //gán dữ liệu
        $slide->image = $request->image;
        //gán dữ liệu
        $slide->slide_status = $request->slide_status;
        //gán dữ liệu
        $slide->slide_desc = $request->slide_desc;
        //lưu
        $slide->save();
        //hiện thông báo
        toastr()->success('Thành công', 'Thêm slide thành công');
        return redirect(route('listSlide'));
    }
    public function unActive($id)
    {
        //Dòng này thực hiện một truy vấn cơ sở dữ liệu để cập nhật trạng thái của slide có id tương ứng thành 0.
        DB::table('slide')->where('id', $id)->update(['slide_status' => 0]);
        //hiện thông báo
        toastr()->error('Lỗi', 'Bạn chưa kích hoạt slide');
        return redirect(route('listSlide'));
    }
    public function active($id)
    {
        //Dòng này thực hiện một truy vấn cơ sở dữ liệu để cập nhật trạng thái của slide có id tương ứng thành 1.
        DB::table('slide')->where('id', $id)->update(['slide_status' => 1]);
        //hiện thông báo
        toastr()->success('Thành công', 'Kích hoạt slide thành công');
        return redirect(route('listSlide'));
    }
    public function delete($id)
    {
        $slide = Slide::find($id);
        $slide->delete($id);
        toastr()->success('Thành công', 'Xoá slide thành công');
        return redirect(route('listSlide'));
    }
    public function loadEdit($id)
    {
        // var_dump($id);
        //Dòng này tìm kiếm slide trong cơ sở dữ liệu dựa trên id được truyền vào và lưu slide đó vào biến $slide
        $slide = Slide::find($id);
        return view('admin.pages.slides.edit', ['slide' => $slide]);
    }
    public function edit(Request $request)
    {
        //Dòng này tìm kiếm slide dựa trên id được truyền qua request và lưu slide đó vào biến $slide để cập nhật thông tin.
        $slide = Slide::find($request->id);
        //Nếu $request->file_upload == '',-> không có tệp ảnh mới được tải lên, sẽ sử dụng ảnh cũ đã lưu trong $request->input('image1') và gán cho biến $image.
        //Nếu có $request->file_upload,user đã tải lên một tệp mới,di chuyển tệp mới đó vào thư mục hình ảnh và gán tên tệp này cho biến $image.
        if ($request->file_upload == '') {
            $image = $request->input('image1');
        } else if ($request->has('file_upload')) {
            $file = $request->file_upload;
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/slides'), $file_name);
            $image = $file_name;
        }
        $slide->name = $request->name;
        $slide->image = $image;
        $slide->slide_status = $request->slide_status;
        $slide->slide_desc = $request->slide_desc;
        //lưu vào db
        $slide->save();
        //hiện thông báo
        toastr()->success('Thành công', 'Chỉnh sửa slide thành công');
        return redirect(route('listSlide'));
    }
}
