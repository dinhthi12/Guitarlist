@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Thêm Sản Phẩm</h4>
                        <p class="card-description">
                            Nhập thông tin
                        </p>
                        <form method="POST" action="{{ route('createPro') }}" enctype="multipart/form-data" id="form-product"
                            class="forms-sample">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputName1">Tên Sản Phẩm</label>
                                <input type="text" name="name" class="form-control fullname" id="exampleInputName1"
                                    placeholder="Nhập tên sản phẩm">
                                <span
                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                    class="form-message"></span>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Danh Mục</label>
                                        <select class="form-control show-cti form-select list" name="danhMuc_id"
                                            id="cate">
                                            <option value="">Chọn danh mục</option>
                                            @foreach ($allCate as $cate)
                                                <option data-id="{{ $cate->id }}" value="{{ $cate->id }}">
                                                    {{ $cate->name }}</option>
                                            @endforeach
                                        </select>
                                        <span
                                            style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                            class="form-message"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Hãng</label>
                                        <select class="form-control show-cti firm" name="category_id" id="cate">
                                        </select>
                                        <span
                                            style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                            class="form-message"></span>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Giá</label>
                                        <input type="number" name="price" class="form-control price"
                                            id="exampleInputName1" placeholder="Nhập Giá Sản Phẩm">
                                        <span
                                            style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                            class="form-message"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Giảm Giá</label>
                                        <input type="number" name="discount" class="form-control discount"
                                            id="exampleInputName1" placeholder="Nhập % Giảm giá">
                                        <span
                                            style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                            class="form-message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Số lượng</label>
                                        <input type="number" name="quantity" class="form-control amount"
                                            id="exampleInputName1" placeholder="Nhập số lượng">
                                        <span
                                            style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                            class="form-message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Hot</label>
                                        <select class="form-control" name="hot" id="exampleSelectGender">
                                            <option value="0" selected>Bình Thường</option>
                                            <option value="1">Hot</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Trạng thái</label>
                                        <select class="form-control status" name="status" id="exampleSelectGender">
                                            <option value="0" selected>Hiển thị</option>
                                            <option value="1">Ẩn</option>
                                        </select>
                                        <span
                                            style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                            class="form-message"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Hình Ảnh</label>
                                <input type="file" name="file_upload" class="form-control avatar">
                                <span
                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                    class="form-message"></span>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail3">Mô tả sản phẩm</label>
                                <textarea class="form-control describe" name="detail" id="editor1" cols="10" rows="25"></textarea>
                                <span
                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                    class="form-message"></span>
                            </div>

                            <div class="form-group">
                                <p>
                                    <a class="btn btn-primary col-sm-3" data-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1" style="margin-right: 1%">Thêm chi tiết sản
                                        phẩm</a>
                                </p>
                                {{-- thêm chi tiết sản phẩm --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                                            <br>
                                            <h4 class="card-title">
                                                <a class="col-sm-3" data-toggle="collapse" href="#multiCollapseExample1"
                                                    role="button" aria-expanded="false"
                                                    aria-controls="multiCollapseExample1" style="margin-right: 1%">Thêm
                                                    chi tiết sản phẩm</a>
                                                <hr>
                                            </h4>
                                            <div class="card card-body">

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Bộ cơ khí</label>
                                                            <input type="text" name="mechanicalSet" class="form-control mechanicalSet"
                                                                id="exampleInputName1" placeholder="Nhập bộ cơ khí">
                                                            <span
                                                                style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                class="form-message"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Bảng âm thanh</label>
                                                            <input type="text" name="soundboard" class="form-control soundboard"
                                                                id="exampleInputName1" placeholder="Nhập bảng âm thanh">
                                                            <span
                                                                style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                class="form-message"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputName1">Bàn phím</label>
                                                            <input type="number" name="keyboard"
                                                                class="form-control keyboard" id="exampleInputName1"
                                                                placeholder="Nhập bàn phím của đàn">
                                                            <span
                                                                style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                class="form-message"></span>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Kích thước</label>
                                                            <input type="text" name="size"
                                                                class="form-control size" id="exampleInputName1"
                                                                placeholder="Nhập thông số kích thước">
                                                            <span
                                                                style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                class="form-message"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Trọng lượng</label>
                                                            <input type="number" name="weight"
                                                                class="form-control weight" id="exampleInputName1"
                                                                placeholder="Nhập trọng lượng">
                                                            <span
                                                                style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                class="form-message"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Sản xuất</label>
                                                            <input type="text" name="manufacture"
                                                                class="form-control manufacture" id="exampleInputName1"
                                                                placeholder="Nhập nơi sản xuất">
                                                            <span
                                                                style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                class="form-message"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Thêm mới</button>
                            <a type="button" href="{{ route('listPro') }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#cate').click(function() {
                var id_cate = $(this).val();
                console.log(id_cate);
                $.ajax({
                    url: '{{ route('loadCateItems') }}',
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_cate: id_cate
                    },
                    success: function(data) {
                        $("select[name='category_id'").html('');
                        $.each(data, function(key, value) {
                            $("select[name='category_id']").append(
                                "<option value=" + value.id + ">" + value.name +
                                "</option>"
                            );
                        });
                    }
                })
            });
        });
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
        Validator.isList = function(selector) {
            return {
                selector,
                test(value) {
                    return value ? undefined : 'Vui lòng chọn danh mục'
                }
            }
        }

        Validator.isFirm = function(selector) {
            return {
                selector,
                test(value) {
                    return value ? undefined : 'Vui lòng chọn hãng'
                }
            }
        }
        Validator.isPrice = function(selector) {
            return {
                selector,
                test(value) {
                    return value ? undefined : 'Vui lòng nhập giá'
                }
            }
        }
        Validator.isDiscount = function(selector) {
            return {
                selector,
                test(value) {
                    return value ? undefined : 'Vui lòng nhập % giảm giá'
                }
            }
        }
        Validator.isAmount = function(selector) {
            return {
                selector,
                test(value) {
                    return value ? undefined : 'Vui lòng nhập số lượng'
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

        // Validator.isStatus = function(selector) {
        //     return {
        //         selector,
        //         test(value) {
        //             return value ? undefined : 'Vui lòng nhập trạng thái'
        //         }
        //     }
        // }

        // Validator.isDescribe = function(selector) {
        //     return {
        //         selector,
        //         test(value) {
        //             return value ? undefined : 'Vui lòng nhập mô tả sản phẩm'
        //         }
        //     }
        // }



        Validator({
            form: '#form-product',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('.fullname'),
                Validator.isList('.list'),
                Validator.isFirm('.firm'),
                Validator.isPrice('.price'),
                Validator.isDiscount('.discount'),
                Validator.isAmount('.amount'),
                Validator.isAvatar('.avatar'),
                // Validator.isStatus('.status')
                // Validator.isDescribe('.describe')
            ],
        })
    </script>
@endsection
