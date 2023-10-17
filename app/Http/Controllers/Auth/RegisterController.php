<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        // Kiểm tra xem địa chỉ email đã tồn tại trong cơ sở dữ liệu chưa
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            // Địa chỉ email đã tồn tại, thông báo lỗi cho người dùng
            toastr()->error('Địa chỉ email này đã được sử dụng.');
            return redirect()->back();
        }

         // Nếu địa chỉ email không bị trùng lặp, tiếp tục quá trình đăng ký
        if ($request->has('file_upload')) {
             // Xử lý tải lên hình ảnh
            $file = $request->file_upload;
            $file_name = date('YmdHi') . $file->getClientOriginalName();
            //dd($file_name);
            $file->move(public_path('images/users'), $file_name);
        }
        $request->merge(['image' => $file_name]);

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $file_name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);
        $adr = new Address();
        $adr->user_id = $user->id;
        $adr->name = $request->name;
        $adr->phone = $request->phone;
        $adr->address = $request->address;
        $adr->status = 1;
        $adr->save();

        // Gửi email xác thực và thông báo thành công
        event(new Registered($user));

        //Auth::login($user);
        toastr()->success('Thành công', 'Đăng ký thành công!');
        return redirect(RouteServiceProvider::HOME);
    }
}
