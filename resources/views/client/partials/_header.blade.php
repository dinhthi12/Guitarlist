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
                                {{-- trả về trang index --}}
                                <li> <a href="{{ Route('index') }}">gift card</a></li>
                                {{-- nếu đăng nhập thì xem được đơn hàng còn chưa đăng nhập thì hiện thông báo "bạn chưa đăng nhập" --}}
                                <li> <a href="{{Route('myOrders')}}">Đơn Hàng</a></li>
                                {{-- trả về trang liên hệ. Nếu đăng nhập mới gửi được form liên hệ còn chưa đăng nhập thì chỉ hiển thị giao diện --}}
                                <li> <a href="{{ Route('contacts') }}">Liên Hệ</a></li>
                                {{-- nếu đăng nhập thì hiển thị hi + username còn chưa đăng nhập thì hiện route đăng ký --}}
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
                    <!-- logo trang web -->
                    <a class="navbar-brand logo_h" href="{{ route('index') }}">
                        <img src="{{ asset('images/logo.svg') }}" width="80px" alt="" />
                    </a>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">
                        <div class="row w-100 mr-0">
                            <div class="col-lg-7 pr-0">
                                <ul class="nav navbar-nav center_nav pull-left" style="padding-left: 50px;">
                                    {{-- lấy danh sách tên của category từ controller ra --}}
                                    @foreach ($allCate as $cate)
                                        <li class="nav-item submenu dropdown">
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
                                        <a href="{{ route('viewCart') }}" class="icons">
                                            <i class="ti-shopping-cart"></i>
                                        </a>
                                    </li>
                                    {{-- kiểm tra user đăng nhập --}}
                                    @if (Auth::check())
                                        <li class="nav-item dropdown">
                                            <a href="#" class="icons dropdown-toggle" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ti-user" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('manager') }}"><i
                                                        class="fa fa-info" aria-hidden="true"></i> Quản lý tài khoản</a>
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
                                            <a href="{{ route('login') }}" class="icons">
                                                <i class="ti-user" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    @endif
                                    {{-- lấy danh sách sản phẩm yêu thích theo từng user --}}
                                    @if (Auth::check())
                                        <li class="nav-item">
                                            @php
                                                $user = Auth::user();
                                                $wishlist = $user->wishlist;
                                                // $wishlistcount = $user->wishlist->count();
                                                // $wishlistcount = $wishlist ? $wishlist->count() : 0;
                                            @endphp
                                            <a href="{{ route('listWish') }}" class="icons" style="height: 50%">
                                                <i class="ti-heart" aria-hidden="true"></i>
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
