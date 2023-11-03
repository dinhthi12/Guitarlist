@extends('client.master')
@section('title', 'Giỏ hàng')
@section('content')
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Chi tiết đơn hàng</h2>
                    </div>
                    <div class="page_link">
                        <a href="{{ Route('index') }}">Trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="row">
                <div class="cart_inner col-md-8">
                    <div class="table-responsive">
                        <table class="table cart-table">
                            <thead>
                                <tr>
                                    <th class="col-md-6" scope="col">Sản phẩm</th>
                                    <th class="col-md-2" scope="col">Số lượng</th>
                                    <th class="col-md-4" scope="col">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($details) && count($details) > 0)
                                    @foreach ($details as $detail)
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <div class="d-flex">
                                                        <img width="100px"
                                                            src="{{ asset('images/products/' . $detail->Product->image) }}"
                                                            alt="" />
                                                    </div>
                                                    <div class="media-body cart-pro-name">
                                                        <p>{{ $detail->name }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p>{{ $detail->number }}</p>
                                            </td>
                                            <td>
                                                <h5 class="cart-total">{{ number_format($detail->price, 0, '.', '.') }} VNĐ
                                                </h5>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">
                                            <p class="no_cart">Chưa có sản phẩm nào trong giỏ hàng</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Payment sidebar --}}
                <div class="payment_info info-order col-md-4">
                    <div class="payment_item">
                        <h3>Thông tin đơn hàng</h3>
                    </div>
                    <br>
                    <div class="payment_item">
                        <p>Mã ĐH: {{ $order->id }}</p>
                        <p>Người nhận: {{ $order->Address->name }}</p>
                        <p>Địa chỉ: {{ $order->Address->address }}</p>
                        <p>SĐT: {{ $order->Address->phone }}</p>

                    </div>
                    <div class="payment_item">
                        <p>Ngày tạo: {{ $order->created_at }}</p>
                        <p>PTGH: {{ $order->Delivery->name }}</p>
                        <p>Trạng thái: @if ($order->status == 0)
                                Đang xử lý
                            @elseif($order->status == 1)
                                Đã xác nhận
                            @elseif($order->status == 2)
                                Đang giao hàng
                            @elseif($order->status == 3)
                                Đã thanh toán
                            @elseif($order->status == 4)
                                Đã hủy
                            @endif
                        </p>
                        <p>Ghi chú: {{ $order->note }}</p>
                    </div>
                    <div class="payment_item payment_total">
                        <p>Giao hàng: {{ number_format($order->Delivery->value, 0, '.', '.') }} VNĐ</p>
                        <p>Giảm giá: {{ number_format($order->discount, 0, '.', '.') }} VNĐ</p>
                        <p>Tổng tiền: {{ number_format($order->total, 0, '.', '.') }} VNĐ</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->
@endsection
