<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="{{ URL::asset('images/logo.svg') }}" />
    <title>@yield('title')</title>
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
        <!-- partial:Admin.partials/_navbar.html -->
        @include('Admin.partials._navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:Admin.partials/_sidebar.html -->
            @include('Admin.partials._sidebar')
            <!-- partial -->
            <div class="main-panel">
                @yield('content')
                <!-- content-wrapper ends -->
                <!-- partial:Admin.partials/_footer.html -->
                @include('Admin.partials._footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ URL::asset('admin/vendors/base/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="{{ URL::asset('admin/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ URL::asset('admin/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ URL::asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ URL::asset('admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ URL::asset('admin/js/template.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ URL::asset('admin/js/dashboard.js') }}"></script>
    <script src="{{ URL::asset('admin/js/data-table.js') }}"></script>
    <script src="{{ URL::asset('admin/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('admin/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>
    {{-- <script src="{{ URL::asset('admin/js/jquery.inputmask.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js" integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- End custom js for this page-->
</body>

</html>
