<header class="header_area">
    <div class="top_menu">
        {{-- start top menu --}}
        <div class="top_menu">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="float-left">
                            <p>Phone: 0796-69-2773</p>
                            <p>email: guitarlist@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="float-right">
                            <ul class="right_side">
                                <li> <a href="#">gift card</a></li>
                                <li> <a href="#">Đơn Hàng</a></li>
                                <li> <a href="#">Liên Hệ</a></li>
                                @if (Auth::check())
                                    <li><a href="#">hi, {{ Auth::user()->name }}</a></li>
                                @else
                                    <li><a href="{{ Route('signup') }}">Đăng Ký</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end top menu --}}
        {{-- start main menu --}}
        <div class="main_menu">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light w-100">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <a class="navbar-brand logo_h" href="{{ route('index') }}">
                        <img src="{{ asset('images/logo.svg') }}" width="80px" alt="" />
                    </a>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">
                        <div class="row w-100 mr-0">
                            <div class="col-lg-7 pr-0">
                                <ul class="nav navbar-nav center_nav pull-left" style="padding-left: 50px;">
                                    @foreach ($allCate as $cate)
                                        <li class="nav-item submenu dropdown">
                                            {{-- lấy danh sách tên của category từ controller ra --}}
                                            <a href="{{ route('getProByCate', $cate->id) }}"
                                                class="nav-link dropdown-toggle">{{ $cate->name }}</a>
                                            <ul class="dropdown-menu">
                                                {{-- Dùng để truy vấn và lấy ra tất cả các danh mục con (Cate_item)
                                                thuộc danh mục gốc hiện tại ($cate->id) và gán chúng vào biến $cate_items --}}
                                                @php
                                                    $cate_items = App\Models\Category::find($cate->id)->Cate_item;
                                                @endphp
                                                @foreach ($cate_items as $item)
                                                    <li class="nav-item">
                                                        <a class="nav-link"
                                                            href="{{ route('getProByCateItem', $item->id) }}">{{ $item->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="col-lg-5 pr-0">
                                <ul class="nav navbar-nav navbar-right right_nav pull-right">
                                    {{-- form tìm kiếm sản phẩm theo tên --}}
                                    <div style="float: left; height:10px;" class="#" id="collapseExample">
                                        <div style=" border: none; padding: 1.05rem;" class="card card-body">
                                            <form action="{{ url('search') }}" method="GET">
                                                @csrf
                                                <div class="input-group">
                                                    <input style="margin-top: 2%;" name="keywords" type="search"
                                                        class="form-control" placeholder="Nhập từ khóa..">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <li class="nav-item" role="presentation">
                                        <a style="border: none; width: 100%;  margin: 15% 0% 0% 0%; " class="icons"
                                            data-toggle="collapse" href="#collapseExample" role="right"
                                            aria-expanded="false" aria-controls="collapseExample">
                                            <i class="ti-search" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="icons">
                                            <i class="ti-shopping-cart"></i>
                                        </a>
                                    </li>
                                    {{-- check user đăng nhập --}}
                                    @if (Auth::check())
                                        <li class="nav-item dropdown">
                                            <a href="#" class="icons dropdown-toggle" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ti-user" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('manager') }}"><i
                                                        class="fa fa-info" aria-hidden="true"></i> Quản lý tài khoản</a>
                                                @if (Auth::user()->role == 1)
                                                    <a class="dropdown-item" href="{{ route('indexAdmin') }}"
                                                        target="_blank"><i class="fa fa-wrench" aria-hidden="true"></i>
                                                        Quản trị Website</a>
                                                @endif
                                                <form action="/logout" method="post">
                                                    @csrf
                                                    <button class="dropdown-item btn-none"><i class="fa fa-sign-out"
                                                            aria-hidden="true"></i>
                                                        Đăng xuất</button>
                                                </form>
                                            </div>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a href="{{ route('login') }}" class="icons"> {{-- data-toggle="modal" data-target="#myModal" --}}
                                                <i class="ti-user" aria-hidden="true"></i>
                                            </a>
                                            {{-- <div class="container">
                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title text-center">Đăng nhập</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('clientLogin') }}"
                                                                    method="POST" id="form-login">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="">Tài khoản</label>
                                                                        <input type="text"
                                                                            class="form-control email" name="email"
                                                                            id="email"
                                                                            aria-describedby="emailHelp"
                                                                            placeholder="Nhập Email của bạn">
                                                                        <span
                                                                            style="font-size: 15px; color: #f33a58;width: 100%; display:block; margin-top:4px;"
                                                                            class="form-message"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">Mật khẩu</label>
                                                                        <input type="password" name="password"
                                                                            class="form-control password"
                                                                            id="password"
                                                                            placeholder="Nhập mật khẩu">
                                                                        <span
                                                                            style="font-size: 15px; color: #f33a58;width: 100%; display:block; margin-top:4px;"
                                                                            class="form-message"></span>

                                                                    </div>
                                                                    <div class="form-check align-items-center">
                                                                        <input type="checkbox" name="remember"
                                                                            class="form-check-input"
                                                                            id="exampleCheck1">
                                                                        <label class="form-check-label my-1"
                                                                            for="exampleCheck1">Lưu thông tin</label>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="my-4 btn btn-lg btn-block btn-form">Đăng
                                                                        nhập</button>

                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <p class="m-0">Bạn chưa có tài khoản ? <a
                                                                        href="#">Đăng ký</a></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div> --}}
                                        </li>
                                    @endif
                                    @if (Auth::check())
                                        <li class="nav-item">
                                            @php
                                                //$wishlistcount = App\Models\Wishlist::count();
                                                $user = Auth::user();
                                                $wishlist = $user->wishlist;
                                                $wishlistcount = $wishlist ? $wishlist->count() : 0;
                                            @endphp
                                            <a href="{{ route('listWish') }}" class="icons" style="height: 50%">
                                                <i class="ti-heart" aria-hidden="true">
                                                    @if ($wishlistcount > 0)
                                                        <div class="shopee-cart-number-badge">
                                                            <span
                                                                style="display: block; line-height: normal; color: rgb(243, 235, 235);">{{ $wishlistcount }}</span>
                                                        </div>
                                                    @endif
                                                </i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
</header>
<script>
    function Validator(options) {
        var formElement = document.querySelector(options.form);
        var selectorRules = {}
        // hàm thực hiện validate
        var selectorRules = {}

        function validate(inputElement, rule) {
            var input = inputElement.parentElement.querySelector('.form-control')
            var errorElement = inputElement.parentElement.querySelector('.form-message');
            var errorMessage
            //
            var rules = selectorRules[rule.selector]

            for (var i = 0; i < rules.length; ++i) {
                errorMessage = rules[i](inputElement.value)
                if (errorMessage) break;
            }
            if (errorMessage) {
                errorElement.innerText = errorMessage;
                input.style.borderColor = '#f33a58'
            } else {
                errorElement.innerText = ''
                input.style.borderColor = ''
            }
            return !errorMessage;
        }

        // lấy element của form
        if (formElement) {
            formElement.onsubmit = function(e) {


                var isFormValid = true

                options.rules.forEach(function(rule) {

                    var inputElement = formElement.querySelector(rule.selector)
                    var isValid = validate(inputElement, rule)
                    if (!isValid) {
                        isFormValid = false
                    }
                });


                if (isFormValid) {
                    formElement.submit()
                } else {
                    e.preventDefault();
                }
            }
            // lặp qua mỗi rule và xửa lý sự kiện
            options.rules.forEach(function(rule) {
                //lu lai cac rules cho moi input

                if (Array.isArray(selectorRules[rule.selector])) {
                    selectorRules[rule.selector].push(rule.test)
                } else {
                    selectorRules[rule.selector] = [rule.test]
                }

                var inputElement = formElement.querySelector(rule.selector)
                var errorElement = inputElement.parentElement.querySelector(options.errorSelector);
                var input = inputElement.parentElement.querySelector('.form-control')

                if (inputElement) {
                    inputElement.onblur = function() {
                        validate(inputElement, rule)
                    }

                    inputElement.oninput = function() {
                        errorElement.innerHTML = ''
                        input.style.borderColor = ''
                    }
                }
            })
        }
    }

    Validator.isPassword = function(selector) {
        return {
            selector,
            test(value) {
                return value ? undefined : 'Vui lòng nhập mật khẩu'
            }
        }
    }
    Validator.formEmail = function(selector) {
        return {
            selector,
            test(value) {
                return value ? undefined : 'Vui lòng nhập email'
            }
        }
    }
    Validator.isEmail = function(selector) {
        return {
            selector,
            test(value) {
                var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                return regex.test(value) ? undefined : 'Vui lòng nhập đúng định dạng email'
            }
        }
    }

    Validator.minLength = function(selector, min) {
        return {
            selector,
            test(value) {
                return value.length >= min ? undefined : `Vui lòng nhập tối đa ${min} ký tự`
            }
        }
    }

    Validator({
        form: '#form-login',
        errorSelector: '.form-message',
        rules: [
            Validator.formEmail('.email'),
            Validator.isEmail('.email'),
            Validator.isPassword('.password'),
            Validator.minLength('.password', 6),
        ],
    })
</script>
