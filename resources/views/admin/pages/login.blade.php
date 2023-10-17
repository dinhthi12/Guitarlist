<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="{{ URL::asset('images/logo.svg')}}" />
    <title>Đăng nhập</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ URL::asset('admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/vendors/base/vendor.bundle.base.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/css/loading-bar.css') }}" />
    <script type="text/javascript" src="{{ URL::asset('admin/js/loading-bar.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ URL::asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ URL::asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/custom.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ URL::asset('images/logo.svg') }}" />

</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('images/logo.svg') }}" alt="logo">
                            </div>
                            <h4 class="text-center">Bạn cần đăng nhập</h4>
                            <h6 class="font-weight-light text-center">Sử dụng tài khoản quản trị để tiếp tục.</h6>
                            <form class="pt-3" method="POST" action="{{ route('adminLogin') }}">
                                @csrf
                                @error('err')
                                    <p class="login-fail text-center">{{ $message }}</p>
                                @enderror
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        id="" placeholder="Nhập Email của bạn">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        id="" placeholder="Mật khẩu">
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Đăng nhập</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Ghi nhớ tài khoản
                                        </label>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
    </div>
    <!-- page-body-wrapper ends -->
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <!-- endinject -->
</body>

</html>
