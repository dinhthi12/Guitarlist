@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Danh sách bình luận</p>
                        <div class="col-md-3" style="float: left;">
                            <!-- onchange="this.form.submit()" để submit -->
                            <form class="card-title" action="{{route('searchName')}}" method="GET">
                                @csrf
                                <div class="form-group">
                                    <select class="form-control show-cti form-select list" name="keywords_pro_id"
                                        id="pro" onchange="this.form.submit()">
                                        <option>Lọc theo tên sản phẩm</option>
                                        <option value="">Tất cả bình luận</option>
                                        @foreach ($allPro as $pro)
                                            <option data-id="{{ $pro->id }}" value="{{ $pro->id }}">
                                                {{ $pro->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>

                        </div>

                        <div class="col-md-3" style="float: left;">
                            <form class="card-title" action="{{route('searchDate')}}" method="GET">
                                @csrf
                                <div class="form-group">
                                    <select class="form-control show-cti form-select list" name="keywords_date"
                                        id="cate" onchange="this.form.submit()">
                                        <option>Lọc theo ngày</option>
                                        <option value="">Tất cả bình luận</option>
                                        @foreach ($allCom1 as $com)
                                            <option data-id="{{ $com->created_at }}" value="{{ $com->created_at }}">
                                                {{ $com->created_at }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div class="row" style=" clear: both; color: red; margin-left: 1%;">
                            <h5>
                                <?php
                                if (isset($mess)) {
                                    echo $mess;
                                }
                                ?>
                            </h5>
                        </div>

                        <div class="table-responsive">
                            <table id="recent-purchases-listing" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Tên người dùng</th>
                                        <th>Nội dung</th>
                                        <th>Sao</th>
                                        <th>Ngày đăng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allCom as $com)
                                        <tr>
                                            <td>{{ $com->id }}</td>
                                            <td>{{ $com->Product->name }}</td>
                                            <td>{{ $com->User->name }}</td>
                                            <td>{{ $com->content }}</td>
                                            <td>{{ $com->rate }}</td>
                                            <td>{{ $com->created_at }}</td>
                                            <td><a class="badge badge-danger rounded"
                                                    onclick="return confirm('Xóa mục này?')"
                                                    href="{{route('deleteCom',$com->id)}}">Xóa</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
