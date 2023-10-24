<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="{{ URL::asset('images/logo.svg') }}" />
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
                            <h6 class="font-weight-light text-center">Sử dụng tài khoản của bạn để tiếp tục.</h6>
                            <form class="pt-3" action="{{ route('clientLogin') }}" method="POST" id="form-login">
                                @csrf
                                @error('err')
                                    <p class="login-fail text-center">{{ $message }}</p>
                                @enderror
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg email"
                                        name="email" id="email" placeholder="Nhập Email của bạn">
                                    <span
                                        style="font-size: 15px; color: #f33a58;width: 100%; display:block; margin-top:4px;"
                                        class="form-message"></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg password"
                                        id="password" placeholder="Mật khẩu">
                                    <span
                                        style="font-size: 15px; color: #f33a58;width: 100%; display:block; margin-top:4px;"
                                        class="form-message"></span>
                                </div>
                                <div class="mt-3">
                                    <button style="background-color: #8B4513; color: #fff" type="submit"
                                        class="btn btn-lg btn-block btn-form">Đăng
                                        nhập</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <p class="m-0">Bạn chưa có tài khoản ? <a href="{{ route('signup') }}">Đăng ký</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
    </div>
</body>

</html>
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
