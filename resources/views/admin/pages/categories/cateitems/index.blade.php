@extends('admin.master')
@section('title', 'Danh mục')
@section('content')

    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Thêm mới danh mục con của {{ $cate->name }}</h4>
                        <form method="POST" action="{{ route('createCateItem') }}" enctype="multipart/form-data"
                            id="form-add-item" class="form-inline">
                            @csrf
                            <div>
                                <input type="hidden" value="{{ $cate->id }}" name="category_id">
                                <label class="sr-only" for="inlineFormInputName2">Tên danh mục con</label>
                                <input type="text" name="name" class="form-control mb-2 mr-sm-2" id="fullname"
                                    placeholder="Tên danh mục con">
                                <span style="font-size: 15px; color: #f33a58; line-height: 3px;   display: block;"
                                    class="form-message"></span>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Thêm Mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Danh mục con của {{ $cate->name }}
                        </h4>
                        <div class="table-responsive pt-3">
                            <table id="recent-purchases-listing" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên Danh Mục</th>
                                        <th>Thời gian đăng</th>
                                        <th>Thời gian thay đổi</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cateItems as $ct)
                                        <tr>
                                            <td>
                                                {{ $ct->id }}
                                            </td>
                                            <td>
                                                {{ $ct->name }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($ct->created_at)->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($ct->updated_at)->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('loadEditCateItem', $ct->id) }}"><button type="button"
                                                        class="btn btn-primary"><i class="mdi mdi-wrench"></i></button></a>
                                                <a href="{{route('deleteCateItem',$ct->id)}}"
                                                    onclick="return confirm('Xóa mục này?')"><button type="button"
                                                        class="btn btn-danger"><i class="mdi mdi-delete"></i></button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            {{ $cateItems->links('admin.pagination') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    return value.trim() ? undefined : 'Vui lòng nhập tên danh mục'
                }
            }
        }

        Validator({
            form: '#form-add-item',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('#fullname'),
            ],
        })
    </script>
@endsection
