@extends('client.master')
@section('title', 'Danh mục')
@section('content')
    @include('client/partials/_nav')
    <section class="cat_product_area section_gap">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="product_top_bar">
                        <div class="left_dorp">
                            <select class="sorting" id="sort-select">
                                {{-- <option value="0">Mặc định phân loại</option> --}}
                                <option value="az">Từ A -> Z</option>
                                <option value="za">Từ Z -> A</option>
                                <option value="tangdan">Giá tăng dần</option>
                                <option value="giamdan">Giá giảm dần</option>
                            </select>
                            @if (isset($MesSearch))
                                <div style="float: left; clear: both; padding: 6% 0% 1% 3%; margin: -3%;">
                                    <h4 style="font-size: 130%;">{{ $MesSearch }}</h4>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="latest_product_inner">
                        <div class="row list-pro" id="products-list">
                            @foreach ($listPro as $pro)
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-product">
                                        <div class="product-img bg-white d-flex align-items-center">
                                            <img class="card-img p-4" src="{{ asset('images/products/' . $pro->image) }}"
                                                alt="" />
                                            <div class="p_icon">
                                                <a href="{{ route('getProById', $pro->id) }}">
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
                                            <a href="#" class="d-block">
                                                <h4>{{ $pro->name }}</h4>
                                            </a>
                                            <div class="mt-3">
                                                <span
                                                    class="mr-4">{{ number_format($pro->price - ($pro->price * $pro->discount) / 100, 0, '.', '.') }}
                                                    đ</span>
                                                @if ($pro->discount > 0)
                                                    <del>{{ number_format($pro->price, 0, '.', '.') }} đ</del>
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
                        {{ $listPro->links('client.pagination') }}
                    </div>


                </div>

                <div class="col-lg-3">
                    <div class="left_sidebar_area">
                        <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                                <h3>Danh mục</h3>
                            </div>
                            <div class="widgets_inner">
                                <form action="" method="post">
                                    <ul class="list" id="cate">
                                        @foreach ($allCate as $cate)
                                            <li class="categories" data-cateid="{{ $cate->id }}">
                                                <a href="{{ route('getProByCate', $cate->id) }}"
                                                    class="">{{ $cate->name }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </form>
                            </div>
                        </aside>

                        <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                                <h3>Thương hiệu sản phẩm</h3>
                            </div>
                            <div class="widgets_inner">
                                <ul class="list" id="cate_items">
                                    @foreach ($cti_bar as $item)
                                        <li>
                                            <a href="{{ route('getProByCateItem', $item->id) }}">{{ $item->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>

                        {{-- <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                                <h3>Bộ lọc giá</h3>
                            </div>
                            <div class="widgets_inner">
                                <div class="range_item">
                                    <div id="slider-range"></div>
                                    <div class="">
                                        <label for="amount">Giá : </label>
                                        <input type="text" id="amount" readonly />
                                    </div>
                                </div>
                            </div>
                        </aside> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#sort-select').on('change', function() {
                var sortBy = $(this).val();
                console.log(sortBy);
                $.ajax({
                    url: '{{ route('sortProducts') }}',
                    method: 'get',
                    data: {
                        sortBy: sortBy,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        console.log(data);

                    },
                    error: function() {
                        alert('Chức năng đang được phát triển thêm.');
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var ctiData = @json($cti_bar);
            var id_cate = $(this).data('cateid');
            console.log(ctiData);
            $('.categories').click(function() {
                $.ajax({
                    url: '{{ route('getCateItemByCate') }}',
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_cate: id_cate
                    },
                    success: function(data) {
                        $("#cate_items").html('');
                        $.each(data, function(key, value) {
                            var link = $('<a/>')
                                .attr('href',
                                    '{{ route('getProByCateItem', '') }}' + '/' + value
                                    .id)
                                .text(value.name);

                            var listItem = $('<li/>').append(link);

                            $("#cate_items").append(listItem);
                        });
                    },
                    error: function() {
                        alert('error');
                    }
                })
            });
        });
    </script>
    <script>
        function addToWishlist(event) {
            if (!authCheck()) {
                event.preventDefault(); // chặn việc theo dõi liên kết
                alert("Bạn chưa đăng nhập. Vui lòng đăng nhập để sử dụng chức năng này.");
            }
        }

        function authCheck() {
            return {{ auth()->check() }};
        }
    </script>
@endsection
