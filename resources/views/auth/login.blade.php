<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="{{ URL::asset('images/logo.svg') }}" />
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vendors/linericon/style.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vendors/lightbox/simpleLightbox.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vendors/nice-select/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vendors/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vendors/jquery-ui/jquery-ui.css') }}" />
    <!-- main css -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/cart.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/temp.css') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
</head>

<body>
    <!--================Header Menu Area =================-->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">


                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" id="form-login">
                            @csrf
                            <div class="form-group">
                                <label for="">Tài khoản</label>
                                <input type="text" class="form-control email" name="email" id="email"
                                    aria-describedby="emailHelp" placeholder="Nhập Email của bạn">
                                <span
                                    style="font-size: 15px; color: #f33a58;width: 100%; display:block; margin-top:4px;"
                                    class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Mật khẩu</label>
                                <input type="password" name="password" class="form-control password" id="password"
                                    placeholder="Nhập mật khẩu">
                                <span
                                    style="font-size: 15px; color: #f33a58;width: 100%; display:block; margin-top:4px;"
                                    class="form-message"></span>

                            </div>
                            <div class="form-check align-items-center">
                                <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label my-1" for="exampleCheck1">Lưu thông tin</label>
                            </div>
                            <button type="submit" class="my-4 btn btn-lg btn-block btn-form">Đăng
                                nhập</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--================ End footer Area  =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ URL::asset('js/popper.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/stellar.js') }}"></script>
    <script src="{{ URL::asset('vendors/lightbox/simpleLightbox.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/isotope/isotope-min.js') }}"></script>
    <script src="{{ URL::asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/counter-up/jquery.counterup.js') }}"></script>
    <script src="{{ URL::asset('js/mail-script.js') }}"></script>
    <script src="{{ URL::asset('js/theme.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>
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
</body>

</html>
