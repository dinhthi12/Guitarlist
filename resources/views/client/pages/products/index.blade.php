@extends('client.master')
@section('title', 'Sản phẩm chi tiết')
@section('content')
    {{-- @include('client/_nav') --}}
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Chi Tiết Sản Phẩm</h2>
                    </div>
                    <div class="page_link">
                        <a href="{{ Route('index') }}">Trang chủ</a>
                        <a href="#">Danh mục</a>
                        <a href="#">Chi tiết sản phẩm</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Single Product Area =================-->
    <div class="product_image_area">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-6 flex justify-center align-items-center">
                    <div class="s_product_img">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img id="pro_img" class="d-block w-100"
                                        src="{{ asset('images/products/' . $pro->image) }}" alt="First slide" />
                                </div>
                                @foreach ($color as $pc)
                                    <div class="carousel-item">
                                        <img class="d-block w-100"
                                            src="{{ asset('images/products/' . $pc->image) }}"alt="Second slide" />
                                    </div>
                                @endforeach
                            </div>
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators"data-slide-to="0" class="active">
                                    <img src="{{ asset('images/products/' . $pro->image) }}" alt=""
                                        style="width:100%; height:100%; padding: 8px;" />
                                </li>
                                @for ($i = 0; $i < count($color); $i++)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i + 1 }}">
                                        <img src="{{ asset('images/products/' . $color[$i]->image) }}" alt=""
                                            style="width:100%; height:100%; padding: 8px;" />
                                    </li>
                                @endfor
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <h3 id='pro_name'>{{ $pro->name }} </h3>
                        <input type="hidden" value="{{ $pro->id }}" id="pro_id">
                        <input type="hidden" value="{{ $pro->image }}" id="pro_image">
                        <div class="d-flex">
                            <h2 class="pr-2 "><span id='pro_price'
                                    data-price="{{ $pro->price - $pro->discount }}">{{ number_format($pro->price - ($pro->price * $pro->discount) / 100, 0, '.', '.') }}</span>
                                <span>VND</span>
                            </h2>
                            @if ($pro->discount > 0)
                                <del class="disnone">{{ number_format($pro->price, 0, '.', '.') }} </span> <span>VND</span>
                                    </h2></del>
                            @endif
                        </div>
                        @if ($pro->discount != 0)
                            <div class="product-item-sale">
                                <div>Giảm {{ $pro->discount }}%</div>
                            </div>
                        @endif
                        <ul class="list">
                            <li><strong>Loại : {{ $pro->Cate_item->name }}</strong></li>
                            <li><strong>Lượt xem : {{ $pro->view }}</strong></li>
                            <li><strong>Tình trạng : còn {{ $pro->quantity }} sản phẩm</strong></li>
                        </ul>
                        @if (isset($color))
                            <p class="var_title">Chọn màu sắc: </p>
                            @foreach ($color as $pc)
                                <span class="pro_color pro_var" data-price="{{ $pc->price }}"
                                    data-image="{{ $pc->image }}">{{ $pc->color }}</span>
                            @endforeach
                        @endif
                        @if (isset($variant))
                            <p class="var_title">Chọn biến thể: </p>
                            @foreach ($variant as $pm)
                                <span class="pro_mem pro_var"
                                    data-price="{{ $pm->price }}">{{ $pm->name }}-{{ $pm->eq }}</span>
                            @endforeach
                        @endif
                        <br>
                        <div class="product_count">
                            <label for="qty">Số lượng:</label>
                            <input type="text" name="qty" id="sst" maxlength="12" value="1"
                                title="Quantity:" class="input-text qty" />
                            <button
                                onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                class="increase items-count" type="button">
                                <i class="lnr lnr-chevron-up"></i>
                            </button>
                            <button
                                onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;"
                                class="reduced items-count" type="button">
                                <i class="lnr lnr-chevron-down"></i>
                            </button>
                        </div>
                        <div class="card_area">
                            <a class="main_btn" id="addCart">Thêm vào giỏ hàng</a>
                            <a class="icon_btn" href="#">
                                <i class="lnr lnr lnr-diamond"></i>
                            </a>
                            <a class="icon_btn" href="#">
                                <i class="lnr lnr lnr-heart"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">Mô tả</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab"
                        aria-controls="review" aria-selected="false">Nhận xét</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="detail-content">
                                <h2>Mô tả sản phẩm</h2>
                                <p>
                                    {!! $pro->detail !!}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="table-responsive">

                                <table class="table tb_details">
                                    <tbody id="var_info">
                                        @if (isset($detail->mechanicalSet))
                                            <tr>
                                                <td>
                                                    <h5>Bộ cơ khí</h5>
                                                </td>
                                                <td class="dt_value">
                                                    <h5>{{ $detail->mechanicalSet }}</h5>
                                                </td>
                                            </tr>
                                        @endif
                                        @if (isset($detail->soundboard))
                                            <tr>
                                                <td>
                                                    <h5>Bảng âm thanh</h5>
                                                </td>
                                                <td class="dt_value">
                                                    <h5>{{ $detail->soundboard }}</h5>
                                                </td>
                                            </tr>
                                        @endif
                                        @if (isset($detail->keyboard))
                                            <tr>
                                                <td>
                                                    <h5>Bàn phím</h5>
                                                </td>
                                                <td class="dt_value">
                                                    <h5>{{ $detail->keyboard }}</h5>
                                                </td>
                                            </tr>
                                        @endif
                                        @if (isset($detail->size))
                                            <tr>
                                                <td>
                                                    <h5>Kích thước</h5>
                                                </td>
                                                <td class="dt_value">
                                                    <h5>{{ $detail->size }} </h5>
                                                </td>
                                            </tr>
                                        @endif
                                        @if (isset($detail->weight))
                                            <tr>
                                                <td>
                                                    <h5>Trọng lượng</h5>
                                                </td>
                                                <td class="dt_value">
                                                    <h5>{{ $detail->weight }}</h5>
                                                </td>
                                            </tr>
                                        @endif
                                        @if (isset($detail->manufacture))
                                            <tr>
                                                <td>
                                                    <h5>Nhà sản xuất</h5>
                                                </td>
                                                <td class="dt_value">
                                                    <h5>{{ $detail->manufacture }}</h5>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                </div>
                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row total_rate">
                                <div class="col-6">
                                    <div class="box_total">
                                        <h5>Tổng thể</h5>
                                        @if (isset($Round))
                                            <h4>{{ $Round }}</h4>
                                            <h6>({{ $coutall }} Nhận xét)</h6>
                                        @else
                                            Chưa có đánh giá
                                        @endif

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="rating_list">
                                        {{-- <h3>Dựa trên {{ $coutall }} nhận xét</h3> --}}

                                        <ul class="list">
                                            <li>
                                                <a>
                                                    5 sao
                                                    <?php
                                                    for ($i = 0; $i < 5; $i++) {
                                                        echo '<i class="fa fa-star"></i>';
                                                    }
                                                    ?>

                                                    {{-- {{ $cout5 }} --}}
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    4 sao
                                                    <?php
                                                    for ($i = 0; $i < 4; $i++) {
                                                        echo '<i class="fa fa-star"></i>';
                                                    }
                                                    ?>
                                                    {{-- {{ $cout4 }} --}}
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    3 sao
                                                    <?php
                                                    for ($i = 0; $i < 3; $i++) {
                                                        echo '<i class="fa fa-star"></i>';
                                                    }
                                                    ?>
                                                    {{-- {{ $cout3 }} --}}

                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    2 sao
                                                    <?php
                                                    for ($i = 0; $i < 2; $i++) {
                                                        echo '<i class="fa fa-star"></i>';
                                                    }
                                                    ?>
                                                    {{-- {{ $cout2 }} --}}
                                                </a>
                                            </li>
                                            <li>
                                                <a>
                                                    1 sao
                                                    <?php
                                                    for ($i = 0; $i < 1; $i++) {
                                                        echo '<i class="fa fa-star"></i>';
                                                    }
                                                    ?>
                                                    {{-- {{ $cout1 }} --}}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="review_list">
                                {{-- @foreach ($comm as $com)
                                    <div class="review_item">
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="img/product/single-product/review-1.png" alt="" />
                                            </div>
                                            <div class="media-body">
                                                <h4>{{ $com->name }} | {{ $com->created_at }}</h4>

                                                <?php
                                                for ($i = 0; $i < $com->status; $i++) {
                                                    echo '<i class="fa fa-star"></i>';
                                                } ?>
                                            </div>
                                        </div>
                                        <p style="margin-left:3%">
                                            {{ $com->content }}
                                        </p>
                                    </div>
                                @endforeach --}}



                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="review_box">
                                <h4>Thêm bài đánh giá</h4>
                                <!-- Đánh giá sao -->

                                <!--Bình luận-->
                                @if (Auth::user() != null)
                                    <form class="row contact_form" action="/product/comment/{{ $pro->id }}"
                                        method="post" id="contactForm form-product" novalidate="novalidate">
                                        @csrf
                                        <p style="margin-left: 3%">Đánh giá của bạn:</p>
                                        <ul class="list">
                                            <!-- CSS -->
                                            <style>
                                                .rating {
                                                    display: flex;
                                                    flex-direction: row-reverse;
                                                    justify-content: center;
                                                }

                                                .rating>input {
                                                    display: none;
                                                }

                                                .rating>label {
                                                    position: relative;
                                                    width: 1em;
                                                    font-size: 2vw;
                                                    color: #FFD600;
                                                    cursor: pointer;
                                                }

                                                .rating>label::before {
                                                    content: "\2605";
                                                    position: absolute;
                                                    opacity: 0;
                                                }

                                                .rating>label:hover:before,
                                                .rating>label:hover~label:before {
                                                    opacity: 1 !important;
                                                }

                                                .rating>input:checked~label:before {
                                                    opacity: 1;
                                                }

                                                .rating:hover>input:checked~label:before {
                                                    opacity: 0.4;
                                                }



                                                p {
                                                    font-size: 1.2rem;
                                                }

                                                @media only screen and (max-width: 600px) {
                                                    h1 {
                                                        font-size: 14px;
                                                    }

                                                    p {
                                                        font-size: 12px;
                                                    }
                                                }
                                            </style>
                                            <!-- End css -->
                                            <!-- sta -->
                                            <div class="rating">
                                                <input type="radio" name="rating status" value="5"
                                                    id="5"><label for="5">☆</label>
                                                <input type="radio" name="rating status" value="4"
                                                    id="4"><label for="4">☆</label>
                                                <input type="radio" name="rating status" value="3"
                                                    id="3"><label for="3">☆</label>
                                                <input type="radio" name="rating status" value="2"
                                                    id="2"><label for="2">☆</label>
                                                <input type="radio" name="rating status" value="1"
                                                    id="1"><label for="1">☆</label>
                                            </div>
                                            <div>

                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="content" id="content" rows="5" placeholder="Nội dung"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <button type="submit" value="submit" class="btn submit_btn">
                                                    Gửi đánh giá
                                                </button>
                                            </div>
                                    </form>
                                    <br>
                                @else
                                    <div>
                                        <br>
                                        <h4>Bạn cần đăng nhập để bình luận</h4> <br>
                                        <a class=" btn submit_btn" href="{{ route('login') }}">Đăng nhập</a>...<a
                                            class="btn submit_btn" href="{{ Route('signup') }}">Đăng kí</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Description Area =================-->
@endsection
