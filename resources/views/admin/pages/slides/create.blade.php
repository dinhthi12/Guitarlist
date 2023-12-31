@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Thêm Slide</h4>
                        <p class="card-description"></p>
                        <form method="POST" action="{{ Route('createSlide') }}" enctype="multipart/form-data"
                            class="forms-sample" id="form-add">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputName1">Tên Slide</label>
                                <input type="text" name="name" class="form-control fullname mb-2 mr-sm-2"
                                    id="exampleInputName1" placeholder="Nhập tên Slide">
                                <span style="font-size: 15px; color: #f33a58; line-height: 3px;   display: block;"
                                    class="form-message"></span>
                            </div>

                            <div class="form-group">
                                <label>Hình Ảnh</label>
                                <input type="file" name="file_upload" class="form-control avatar">
                                <span
                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                    class="form-message"></span>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Mô tả Slider</label>
                                        <textarea style="resize: none" rows="8" class="form-control description mb-2 mr-sm-2" name="slide_desc"
                                            id="exampleInputPassword1" placeholder="Mô tả danh mục"></textarea>
                                        <span style="font-size: 15px; color: #f33a58; line-height: 3px;   display: block;"
                                            class="form-message"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Trạng Thái</label>
                                    <select name="slide_status" class="form-control input-sm m-bot-15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiển thị</option>
                                    </select>
                                </div>
                                <div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="button" class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>P

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

                    var inputElement = formElement.querySelector(rule.selector);

                    var errorElement = inputElement.parentElement.querySelector(options.errorSelector);
                    console.log(errorElement);
                    var input = inputElement.parentElement.querySelector('.form-control')
                    console.log(input);

                    if (inputElement) {
                        inputElement.onblur = function() {
                            validate(inputElement, rule)
                        }
                        inputElement.oninput = function() {
                            errorElement.innerText = ''
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
                    return value.trim() ? undefined : 'Vui lòng nhập tên sản phẩm'
                }
            }
        }

        Validator.isAvatar = function(selector) {
            return {
                selector,
                test(value) {
                    return value ? undefined : 'Vui lòng chọn ảnh'
                }
            }
        }

        Validator({
            form: '#form-add',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('.fullname'),
                Validator.isRequired('.description'),
                Validator.isAvatar('.avatar'),
            ],
        })
    </script>
@endsection
