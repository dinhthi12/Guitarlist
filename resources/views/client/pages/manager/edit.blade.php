@extends('client.master')
@section('title', 'Thông tin tài khoản')
@section('content')
    <main>
        <section>
            <div class="container bg-light">
                <form method="POST" action="{{route('updateAccount')}}" enctype="multipart/form-data" class="forms-sample" id="form-register">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 border-right m-auto">
                            <div class="d-flex flex-column relative align-items-center text-center p-3 py-5">
                                <img id="image" class="object-cover w-full h-full"
                                    src="{{ asset('images/users') }}/{{ Auth::user()->image }}" />
                                <div class="absolute top-0 left-0 right-0 bottom-0 w-full block cursor-pointer flex items-center justify-center"
                                    onClick="document.getElementById('fileInput').click()">
                                    <button type="button" style="background-color: rgba(255, 255, 255, 0.65)"
                                        class="hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 text-sm border border-gray-300 rounded-lg shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                            <path
                                                d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                            <circle cx="12" cy="13" r="3" />
                                        </svg>
                                    </button>
                                </div>
                                <input name="file_upload" id="fileInput" accept="image/*" class="hidden" type="file"
                                    onChange="let file = this.files[0];
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                            document.getElementById('image').src = e.target.result;
                                            document.getElementById('image2').src = e.target.result;
                                            };
                                            reader.readAsDataURL(file);
                                ">
                                <span class="font-weight-bold">{{ Auth::user()->name }}</span>

                            </div>
                        </div>
                        <div class="col-md-9 border-right">
                            <div class="p-3 py-5">

                                <input type="hidden" name="image1" value="{{ Auth::user()->image }}" id="">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-right">Thay đổi thông tin</h4>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="labels">Họ và tên</label>
                                        <input disabled type="text" class="form-control" placeholder="Họ và tên"
                                            name="name" value="{{ Auth::user()->name }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="labels">Địa chỉ email</label>
                                        <input disabled type="text" class="form-control" name="email"
                                            value="{{ Auth::user()->email }}" placeholder="Địa chỉ email">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="labels">Địa chỉ</label>
                                        <input type="text" class="form-control address" placeholder="Địa chỉ"
                                            value="{{ Auth::user()->address }}" name="address">
                                        <span style="font-size: 15px; color: #f33a58;width: 100%;"
                                            class="form-message"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labels">Số điện thoại</label>
                                        <input type="text" class="form-control myPhone" value="{{ Auth::user()->phone }}"
                                            name="phone" placeholder="Số điện thoại">
                                        <span style="font-size: 15px; color: #f33a58;width: 100%;"
                                            class="form-message"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="labels">Trạng thái</label>
                                        <input type="text" disabled class="form-control" placeholder="Trạng thái"
                                            value="@if (Auth::user()->status == 1) Chưa kích hoạt
                                            @else Kích hoạt @endif ">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labels">Vai trò</label>
                                        <input type="text" disabled class="form-control"
                                            value="@if (Auth::user()->role == 1) Quản trị viên
                                            @else Thành viên @endif "
                                            placeholder="Vai trò">
                                    </div>
                                    <!-- <div class="col-md-12">
                                                                        <label class="labels">Hình ảnh</label>
                                                                        <div class="row">
                                                                            <img class="col-md-2" src="{{ asset('images/users/' . Auth::user()->image) }}" width="30%" alt="Không có ảnh">
                                                                            <input type="file" class="form-control col-md-10 m-auto" name="file_upload" >
                                                                        </div>

                                                                    </div>  -->
                                </div>
                                <div class="mt-5 text-center">
                                    <button class="btn btn-form" type="submit">Cập nhật tài khoản</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
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

        Validator.isAddress = function(selector, message) {
            return {
                selector,
                test(value) {
                    return value ? undefined : message || 'Vui lòng nhập địa chỉ'
                }
            }
        }
        Validator.formPhome = function(selector) {
            return {
                selector,
                test(value) {
                    return value ? undefined : 'Vui lòng nhập số điện thoại'
                }
            }
        }

        Validator.isPhone = function(selector, min, message) {
            return {
                selector,
                test(value) {
                    const vietnamesePhoneNumberPattern = /^(03[2-9]|07[06-9]|08[1-46-8]|09[0-46-9]|01[2-9])[0-9]{7}$/;
                    return vietnamesePhoneNumberPattern.test(value) ? undefined : `Vui lòng nhập đúng định dạng `
                }
            }
        }

        Validator({
            form: '#form-register',
            errorSelector: '.form-message',
            rules: [
                Validator.isAddress('.address', 'Vui lòng nhập địa chỉ'),
                Validator.formPhome('.myPhone'),
                Validator.isPhone('.myPhone', 10),
            ],
        })
    </script>
@endsection
