@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">
              Danh sách quản trị viên
            </p>

            <div class="col-md-4" style="float: left; margin:-2% 0% 2% -1%;">

                <form action="{{route('searchNameAdmin')}}" method="GET">
                    @csrf
                    <div class="input-group">
                       <input style="margin-top: 2%;" name="keywords" type="search" class="form-control" placeholder="Lọc người dùng...">
                    </div>
                </form>
            </div>

            <div style=" clear: both; color: red; margin-left: 1%; margin: 0% 0% 0% 1%" class="row" >
              <h5>
                <?php
                  if(isset($message)){
                    echo $message;
                  }
                ?>
              </h5>
            </div>


            <div class="table-responsive">
              <table id="recent-purchases-listing" class="table table-hover">
                <thead>
                  <tr>
                      <th>Id</th>
                      <th>Tên người dùng</th>
                      <th>Ảnh</th>
                      <th>Email</th>
                      <th>SĐT</th>
                      <th>Địa chỉ</th>
                      <th>Trạng thái</th>
                      <th>Ngày tạo</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($allUser as $user)
                  <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td><img src="{{asset('images/users/'.$user->image)}}" alt="" style="width:100px; height:100px"></td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->address}}</td>
                    <td>
                        <?php
                            if($user->status==0){
                                echo 'Kích hoạt';
                            }else{
                                echo 'Chưa kích hoạt';
                            }
                        ?>
                    </td>
                    <td>{{$user->created_at}}</td>
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
