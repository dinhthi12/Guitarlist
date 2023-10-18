@extends('client.master')
@section('title', 'Guitarlist')
@section('content')
    <!--================Home Banner Area =================-->
    <section id="slider"><!--slider-->
        <div id="demo" class="carousel slide container" data-ride="carousel">
            <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
            </ul>
            <div class="carousel-inner">
                @foreach ($allSlide as $key => $slide)
                    {{-- Nếu $key (vị trí của phần tử) bằng 0 (tức là phần tử đầu tiên),
                 thì lớp CSS "active" sẽ được thêm vào thẻ <div> để đánh dấu phần tử đầu tiên sẽ hiển thị khi trang web tải lên. --}}
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        @if ($slide->image)
                            <img src="{{ asset('images/slides/' . $slide->image) }}" alt="slide1" width="110%"
                                height="200px">
                        @endif
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </section><!--/slider-->
    <!--================End Home Banner Area =================-->

    <!-- Start feature Area -->
    <section class="feature-area section_gap_bottom_custom">
        <div class="container">
            <div class="row" style="margin-top: 25px">
                <div class="col-lg-3 col-md-6">
                    <div class="single-feature">
                        <a href="#" class="title">
                            <i class="flaticon-money"></i>
                            <h3>Người nhận tiền hoàn lại</h3>
                        </a>
                        <p>Sẽ mở chia một</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-feature">
                        <a href="#" class="title">
                            <i class="flaticon-truck"></i>
                            <h3>Giao hàng miễn phí</h3>
                        </a>
                        <p>Sẽ mở chia một</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-feature">
                        <a href="#" class="title">
                            <i class="flaticon-support"></i>
                            <h3>Luôn hỗ trợ</h3>
                        </a>
                        <p>Sẽ mở chia một</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-feature">
                        <a href="#" class="title">
                            <i class="flaticon-blockchain"></i>
                            <h3>Thanh toán an toàn</h3>
                        </a>
                        <p>Sẽ mở chia một</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End feature Area -->

    <div class="container">
        <div class=" row quick-sales">
            <div class="col-lg-3 item-img">
                <img src="images/banner/banner3.jpg" alt="">
            </div>
            <div class="col-lg-3 item-img">
                <img src="images/banner/banner2.jpg" alt="">
            </div>
            <div class="col-lg-3 item-img">
                <img src="images/banner/banner3.jpg" alt="">
            </div>
            <div class="col-lg-3 item-img">
                <img src="images/banner/banner2.jpg" alt="">
            </div>
        </div>
    </div>
    <!--================ Feature Product Area =================-->
    <section class="feature_product_area section_gap_bottom_custom">
        <div class="container">
            <div class="row justify-content-center list-pro">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2><span>Sản phẩm nổi bật</span></h2>
                    </div>
                </div>
            </div>
            <div class="row list-pro">
                @foreach ($homeTopPr as $pro)
                    <div class="col-lg-3 col-md-6">
                        <div class="single-product">
                            <div class="product-img bg-white d-flex align-items-center" style="height: 290px;">
                                <img class="img-fluid w-100 p-4" src="{{ asset('images/products/' . $pro->image) }}"
                                    alt="" />
                                <div class="p_icon">
                                    <a href="{{ Route('getProById', $pro->id) }}">
                                        <i class="ti-eye"></i>
                                    </a>
                                    <a href="{{ auth()->check() ? route('addWish', $pro->id) : 'javascript:void(0);' }}"
                                        onclick="addToWishlist(event)">
                                        <i class="ti-heart"></i>
                                    </a>
                                    <a href="#">
                                        <i class="ti-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-btm">
                                <a href="{{ Route('getProById', $pro->id) }}" class="d-block">
                                    <h4>{{ $pro->name }}</h4>
                                </a>
                                <div class="mt-2">
                                    <span class="mr-4">
                                        {{-- Dòng này tính giá sản phẩm sau khi được giảm giá (nếu có). Hàm number_format được sử dụng để định dạng giá theo định dạng số nguyên,
                                         với số 0 sau dấu thập phân và dấu chấm (.) được sử dụng để ngăn cách hàng nghìn.
                                         Cụ thể, nó tính giá bằng cách trừ đi phần giảm giá từ giá gốc và hiển thị kết quả với đơn vị "VND." --}}
                                        <h2>{{ number_format($pro->price - ($pro->price * $pro->discount) / 100, 0, '.', '.') }}
                                            VND</h2>
                                    </span>
                                    {{-- Nếu sản phẩm có giảm giá, thì dòng này sẽ sử dụng thẻ <del> để gạch ngang giá gốc (trước khi giảm giá) và hiển thị giá gốc --}}
                                    @if ($pro->discount > 0)
                                        <del>{{ number_format($pro->price, 0, '.', '.') }} VND</del>
                                    @endif
                                </div>
                            </div>
                            @if ($pro->hot == 1)
                                <div class="product-top">
                                    <span class="product-top--text">HOT</span>
                                </div>
                            @endif
                            @if ($pro->discount != 0)
                                <div class="product-item">
                                    <div class="product-item_sale">
                                        <div>Giảm {{ $pro->discount }}%</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--================ End Feature Product Area =================-->

    <!--================ Offer Area =================-->

    <!--================ End Offer Area =================-->

    <!--================ New Product Area =================-->
    <section class="new_product_area section_gap_top section_gap_bottom_custom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2><span>Sản phẩm mới</span></h2>
                    </div>
                </div>
            </div>

            <div class="row list-pro">
                <div class="col-lg-6">
                    <div class="new_product">
                        <h5 class="text-uppercase">{{ $homeNewPr[0]->Cate_item->name }}</h5>
                        <h3 class="text-uppercase">{{ $homeNewPr[0]->name }}</h3>
                        <div class="product-img">
                            <img class="img-fluid" src="{{ asset('images/products/' . $homeNewPr[0]->image) }}"
                                alt="" />

                        </div>
                        <div class="mt-2">
                            <h3>{{ number_format($homeNewPr[0]->price - ($homeNewPr[0]->price * $homeNewPr[0]->discount) / 100, 0, '.', '.') }}
                                VND</h3>
                            @if ($homeNewPr[0]->discount > 0)
                                <del>{{ number_format($homeNewPr[0]->price, 0, '.', '.') }} VND</del>
                            @endif
                        </div>
                        <a href="{{ Route('getProById', $homeNewPr[0]) }}" class="main_btn">Xem chi tiết</a>
                    </div>

                </div>

                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="row ">
                        @for ($i = 1; $i < count($homeNewPr); $i++)
                            <div class="col-lg-6 col-md-6">
                                <div class="single-product">
                                    <div class="product-img bg-white d-flex align-items-center" style="height: 290px;">
                                        <img class="img-fluid w-100 p-4"
                                            src="{{ asset('images/products/' . $homeNewPr[$i]->image) }}"
                                            alt="" />
                                        <div class="p_icon">
                                            <a href="{{ Route('getProById', $homeNewPr[$i]) }}">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="{{ auth()->check() ? route('addWish', $pro->id) : 'javascript:void(0);' }}"
                                                onclick="addToWishlist(event)">
                                                <i class="ti-heart"></i>
                                            </a>
                                            <a href="#">
                                                <i class="ti-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-btm">
                                        <a href="{{ Route('getProById', $homeNewPr[$i]) }}" class="d-block">
                                            <h4>{{ $homeNewPr[$i]->name }}</h4>
                                        </a>
                                        <div class="mt-2">
                                            <span class="mr-4">
                                                <h2>{{ number_format($homeNewPr[$i]->price - ($homeNewPr[$i]->price * $homeNewPr[$i]->discount) / 100, 0, '.', '.') }}
                                                    VND</h2>
                                            </span>
                                            @if ($homeNewPr[$i]->discount > 0)
                                                <del>{{ number_format($homeNewPr[$i]->price, 0, '.', '.') }} VND</del>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($homeNewPr[$i]->discount != 0)
                                        <div class="product-item">
                                            <div class="product-item_sale">
                                                <div>Giảm {{ $homeNewPr[$i]->discount }}%</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($homeNewPr[$i]->hot == 1)
                                        <div class="product-top">
                                            <span class="product-top--text">HOT</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End New Product Area =================-->

    <!--================ Inspired Product Area =================-->
    <section class="inspired_product_area section_gap_bottom_custom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2><span>Sản phẩm khuyến mãi</span></h2>
                    </div>
                </div>
            </div>

            <div class="row list-pro">
                @foreach ($homeSalePr as $pro)
                    <div class="col-lg-3 col-md-6">
                        <div class="single-product">
                            <div class="product-img bg-white d-flex align-items-center" style="height: 290px;">
                                <img class="img-fluid w-100 p-4" src="{{ asset('images/products/' . $pro->image) }}"
                                    alt="" />
                                <div class="p_icon">
                                    <a href="{{ Route('getProById', $pro->id) }}">
                                        <i class="ti-eye"></i>
                                    </a>
                                    <a href="{{ auth()->check() ? route('addWish', $pro->id) : 'javascript:void(0);' }}"
                                        onclick="addToWishlist(event)">
                                        <i class="ti-heart"></i>
                                    </a>
                                    <a href="#">
                                        <i class="ti-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-btm">
                                <a href="{{ Route('getProById', $pro->id) }}" class="d-block">
                                    <h4>{{ $pro->name }}</h4>
                                </a>
                                <div class="mt-2">
                                    <span class="mr-4">
                                        <h2>{{ number_format($pro->price - ($pro->price * $pro->discount) / 100, 0, '.', '.') }}
                                            VND</h2>
                                    </span>
                                    @if ($pro->discount > 0)
                                        <del>{{ number_format($pro->price, 0, '.', '.') }} VND</del>
                                    @endif
                                </div>
                            </div>
                            @if ($pro->discount != 0)
                                <div class="product-item">
                                    <div class="product-item_sale">
                                        <div>Giảm {{ $pro->discount }}%</div>
                                    </div>
                                </div>
                            @endif

                            @if ($pro->hot == 1)
                                <div class="product-top">
                                    <span class="product-top--text">HOT</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--================ End Inspired Product Area =================-->

    <!--================ Start Blog Area =================-->
    <section class="blog-area section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2><span>blog mới nhất</span></h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-blog">
                        <div class="thumb">
                            <img class="img-fluid" src="images/blogs/blog2.png" alt="">
                        </div>
                        <div class="short_details">
                            <div class="meta-top d-flex">
                                <a href="http://htguitarcenter.vn/chuyen-muc/blog/">Bởi quản trị viên</a>
                                <a href="http://htguitarcenter.vn/chuyen-muc/blog/"><i class="ti-comments-smiley"></i>2
                                    Bình luận</a>
                            </div>
                            <a class="d-block" href="http://htguitarcenter.vn/chuyen-muc/blog/">
                                <h4>Đàn acoustic và classic giá tiền khác nhau thế nào?</h4>
                            </a>
                            <div class="text-wrap">
                                <p>
                                    Rất nhiều khách hàng thắc mắc đàn guitar khác giá tiền khác nhau về điểm nào. Hôm nay
                                    chúng ta cùng tìm hiểu rõ hơn về vấn đề này trong bài viết này nhé...
                                </p>
                            </div>
                            <a href="http://htguitarcenter.vn/chuyen-muc/blog/" class="blog_btn">Tìm hiểu thêm <span
                                    class="ml-2 ti-arrow-right"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-blog">
                        <div class="thumb">
                            <img class="img-fluid" src="images/blogs/blog1.jpg" alt="">
                        </div>
                        <div class="short_details">
                            <div class="meta-top d-flex">
                                <a href="http://htguitarcenter.vn/chuyen-muc/blog/">Bởi quản trị viên</a>
                                <a href="http://htguitarcenter.vn/chuyen-muc/blog/"><i class="ti-comments-smiley"></i>2
                                    Bình luận</a>
                            </div>
                            <a class="d-block" href="http://htguitarcenter.vn/chuyen-muc/blog/">
                                <h4>Cách đọc Tab Guitar từ Cơ bản đến Nâng Cao</h4>
                            </a>
                            <div class="text-wrap">
                                <p>
                                    Tab Guitar là một cách thức căn bản ghi lại một bài hát, bản nhạc guitar mà không cần
                                    dùng đến nốt nhạc.Đồng thời cũng phải thuộc vị trí cũng như tên gọi của dây...
                                </p>
                            </div>
                            <a href="http://htguitarcenter.vn/chuyen-muc/blog/" class="blog_btn">Tìm hiểu thêm <span
                                    class="ml-2 ti-arrow-right"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-blog">
                        <div class="thumb">
                            <img class="img-fluid" src="images/blogs/blog3.png" alt="">
                        </div>
                        <div class="short_details">
                            <div class="meta-top d-flex">
                                <a href="http://htguitarcenter.vn/chuyen-muc/blog/">Bởi quản trị viên</a>
                                <a href="http://htguitarcenter.vn/chuyen-muc/blog/"><i class="ti-comments-smiley"></i>2
                                    Bình luận</a>
                            </div>
                            <a class="d-block" href="single-blog.html">
                                <h4>Độc Tấu Guitar Trịnh Công Sơn | Guitar Nhạc Trịnh Đặc Sắc</h4>
                            </a>
                            <div class="text-wrap">
                                <p>
                                    Nhạc Sĩ Trịnh Công Sơn đã từng nhận mình là "Người tình của cuộc sống" nhưng trong chính
                                    những ca khúc của mình ông lại là một người tình thầm lặng...
                                </p>
                            </div>
                            <a href="http://htguitarcenter.vn/chuyen-muc/blog/" class="blog_btn">Tìm hiểu thêm <span
                                    class="ml-2 ti-arrow-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Blog Area =================-->
    <script>
        function addToWishlist(event) {
            if (!authCheck()) {
                event.preventDefault(); // Prevent the link from being followed

                // Show an alert
                alert("Bạn chưa đăng nhập. Vui lòng đăng nhập để sử dụng chức năng này.");
            }
        }

        function authCheck() {
            return {{ auth()->check() }};
        }
    </script>
@endsection
