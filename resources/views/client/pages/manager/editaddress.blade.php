@extends('client.master')
@section('title', 'Thông tin tài khoản')
@section('content')
    <main>
        <section>
            <div class="container bg-light">
                <form method="POST" action="{{ route('editAddress') }}" enctype="multipart/form-data" class="forms-sample"
                    id="formedit-address">
                    @csrf
                    <div class="row">
                        <div class="col border-right">
                            <div class="p-3 py-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-right">Chỉnh sửa địa chỉ</h4>
                                </div>
                                <div class="row mt-2">
                                    <input type="hidden" class="form-control" placeholder="" name="id"
                                        value="{{ $adr->id }}">

                                    <input type="hidden" class="form-control" placeholder="" name="user_id"
                                        value="{{ Auth::user()->id }}">

                                    <div class="col-md-6">
                                        <label class="labels">Họ và tên</label>

                                        <input type="text" class="form-control fullname" placeholder="" name="name"
                                            value="{{ $adr->name }}">
                                        <span style="font-size: 15px; color: #f33a58;width: 100%;"
                                            class="form-message"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labels">Số điện thoại</label>
                                        <input type="text" class="form-control myPhone" value="{{ $adr->phone }}"
                                            name="phone" placeholder="">
                                        <span style="font-size: 15px; color: #f33a58;width: 100%;"
                                            class="form-message"></span>
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="labels">Địa chỉ</label>
                                        <input type="text" class="form-control address" name="address"
                                            value="{{ $adr->address }}" placeholder="">
                                        <span style="font-size: 15px; color: #f33a58;width: 100%;"
                                            class="form-message"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labels">Trạng thái</label>
                                        <select class="form-control w-100" name="status" required>
                                            <option value="0">Tạm thời</option>
                                            <option value="1">Mặc định</option>
                                        </select>

                                    </div>

                                </div>
                                <div class="mt-5 text-center">
                                    <button class="btn btn-form" type="submit">Chỉnh sửa địa chỉ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
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

            Validator.isRequired = function(selector) {
                return {
                    selector,
                    test(value) {
                        return value.trim() ? undefined : 'Vui lòng nhập tên'
                    }
                }
            }


            Validator.isAddress = function(selector, message) {
                return {
                    selector,
                    test(value) {
                        return value ? undefined : message || 'Vui lòng nhập'
                    }
                }
            }

            Validator.phoneMail = function(selector) {
                return {
                    selector,
                    test(value) {
                        return value.trim() ? undefined : 'Vui lòng nhập số điện thoại'
                    }
                }
            }

            Validator.isPhone = function(selector, min, message) {
                return {
                    selector,
                    test(value) {
                        return value.length == min ? undefined : `Vui lòng nhập tối thiểu ${min} số `
                    }
                }
            }


            Validator({
                form: '#formedit-address',
                errorSelector: '.form-message',
                rules: [
                    Validator.isRequired('.fullname'),
                    Validator.isAddress('.address', 'Vui lòng nhập địa chỉ'),
                    Validator.phoneMail('.myPhone'),
                    Validator.isPhone('.myPhone', 10),
                ],
            })
        </script>
    @endsection
