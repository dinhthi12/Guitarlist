@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sửa Sản Phẩm</h4>
                        <p class="card-description">
                            Nhập thông tin
                        </p>
                        <form method="POST" action="{{ route('editPro') }}" enctype="multipart/form-data"
                            id="form-edit-product" class="forms-sample">
                            @csrf
                            <input type="hidden" name="id" value="{{ $pro->id }}" id="">
                            <input type="hidden" name="image1" value="{{ $pro->image }}" id="">
                            <div class="form-group">
                                <label for="exampleInputName1">Tên Sản Phẩm</label>
                                <input type="text" name="name" value="{{ $pro->name }}"
                                    class="form-control fullname" id="exampleInputName1" placeholder="Nhập tên sản phẩm">
                                <span
                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                    class="form-message"></span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Danh Mục</label>
                                        <select class="form-control show-cti list" name="categories" id="cate">
                                            @foreach ($allCate as $cate)
                                                @if ($cate->id == $pro->Cate_item->Category->id)
                                                    <option data-id="{{ $cate->id }}" selected
                                                        value="{{ $cate->id }}">{{ $cate->name }}</option>
                                                @else
                                                    <option data-id="{{ $cate->id }}" value="{{ $cate->id }}">
                                                        {{ $cate->name }}</option>
                                                @endif
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
                                        <select class="form-control show-cti firm" name="category_id">
                                            @foreach ($allCateItems as $cti)
                                                @if ($cti->id == $pro->Cate_item->id)
                                                    <option selected value="{{ $cti->id }}">{{ $cti->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $cti->id }}">{{ $cti->name }}</option>
                                                @endif
                                            @endforeach
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
                                        <input type="number" value="{{ $pro->price }}" name="price"
                                            class="form-control price" id="exampleInputName1"
                                            placeholder="Nhập Giá Sản Phẩm">
                                        <span
                                            style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                            class="form-message"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Giảm Giá</label>
                                        <input type="number" value="{{ $pro->discount }}" name="discount"
                                            class="form-control discount" id="exampleInputName1"
                                            placeholder="Nhập % Giảm giá">
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
                                        <input type="number" value="{{ $pro->quantity }}" name="quantity"
                                            class="form-control amount" id="exampleInputName1" placeholder="Nhập số lượng">
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
                                            @if ($pro->hot == 0)
                                                <option value="0" selected>Bình Thường</option>
                                                <option value="1">Hot</option>
                                            @else
                                                <option value="0">Bình Thường</option>
                                                <option value="1" selected>Hot</option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Trạng thái</label>
                                        <select class="form-control status" name="status" id="exampleSelectGender">
                                            @if ($pro->status == 0)
                                                <option value="0" selected>Hiển thị</option>
                                                <option value="1">Ẩn</option>
                                            @else
                                                <option value="0">Hiển thị</option>
                                                <option value="1" selected>Ẩn</option>
                                            @endif
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
                                        <label>Hình Ảnh</label>
                                        <input type="file" name="file_upload" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{ asset('images/products/' . $pro->image) }}" width="30%"
                                        alt="ko cos anh">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail3">Mô tả sản phẩm</label>
                                <textarea class="form-control describe" name="detail" id="editor1" cols="10" rows="25">{{ $pro->detail }}</textarea>
                                <span
                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                    class="form-message"></span>
                            </div>

                            <div class="form-group">
                                @if (isset($pro_detail))
                                    <p>
                                        <a class="btn btn-primary col-sm-3" data-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1" style="margin-right: 1%">Sửa chi tiết
                                            sản phẩm</a>
                                    </p>
                                @else
                                    <p>
                                        <a class="btn btn-primary col-sm-3" data-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1" style="margin-right: 1%">Thêm chi tiết
                                            sản phẩm</a>
                                    </p>
                                @endif
                                <!-- sửa chi tiết -->
                                @if (isset($pro_detail))
                                    <div class="row">
                                        <div class="col">
                                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                                <br>
                                                <h4 class="card-title">
                                                    <a class="col-sm-3" data-toggle="collapse"
                                                        href="#multiCollapseExample1" role="button"
                                                        aria-expanded="false" aria-controls="multiCollapseExample1"
                                                        style="margin-right: 1%">Sửa chi tiết sản phẩm</a>
                                                    <hr>
                                                </h4>
                                                <div class="card card-body">

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="exampleSelectGender">Bộ cơ khí</label>
                                                                <input type="text" name="mechanicalSet"
                                                                    value="{{ $pro_detail->mechanicalSet }}"
                                                                    class="form-control cpu" id="exampleInputName1"
                                                                    placeholder="Nhập bộ cơ khí">
                                                                <span
                                                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                    class="form-message"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="exampleSelectGender">Bảng âm thanh</label>
                                                                <input type="text" name="soundboard"
                                                                    value="{{ $pro_detail->soundboard }}"
                                                                    class="form-control soundboard" id="exampleInputName1"
                                                                    placeholder="Nhập bảng âm thanh">
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
                                                                    value="{{ $pro_detail->keyboard }}"
                                                                    class="form-control keyboard" id="exampleInputName1"
                                                                    placeholder="Nhập Bàn phím của đàn">
                                                                <span
                                                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                    class="form-message"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="exampleSelectGender">Kích thước</label>
                                                                <input type="text" name="size"
                                                                    value="{{ $pro_detail->size }}"
                                                                    class="form-control size" id="exampleInputName1"
                                                                    placeholder="Nhập thông số kích thước">
                                                                <span
                                                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                    class="form-message"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="exampleSelectGender">Trọng lượng</label>
                                                                <input type="number" name="weight"
                                                                    value="{{ $pro_detail->weight }}"
                                                                    class="form-control weight" id="exampleInputName1"
                                                                    placeholder="Nhập thông số trọng lượng">
                                                                <span
                                                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                    class="form-message"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="exampleSelectGender">Sản xuất</label>
                                                                <input type="text" name="manufacture"
                                                                    value="{{ $pro_detail->manufacture }}"
                                                                    class="form-control manufacture"
                                                                    id="exampleInputName1"
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
                                @else
                                    {{-- thêm chi tiết sản phẩm --}}
                                    <div class="row">
                                        <div class="col">
                                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                                <br>
                                                <h4 class="card-title">
                                                    <a class="col-sm-3" data-toggle="collapse"
                                                        href="#multiCollapseExample1" role="button"
                                                        aria-expanded="false" aria-controls="multiCollapseExample1"
                                                        style="margin-right: 1%">Thêm
                                                        chi tiết sản phẩm</a>
                                                    <hr>
                                                </h4>
                                                <div class="card card-body">

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="exampleSelectGender">Bộ cơ khí</label>
                                                                <input type="text" name="mechanicalSet"
                                                                    class="form-control mechanicalSet"
                                                                    id="exampleInputName1" placeholder="Nhập bộ cơ khí">
                                                                <span
                                                                    style="font-size: 15px; color: #f33a58; line-height: 3px; padding-top: 10px;  display: block;"
                                                                    class="form-message"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="exampleSelectGender">Bảng âm thanh</label>
                                                                <input type="text" name="soundboard"
                                                                    class="form-control soundboard" id="exampleInputName1"
                                                                    placeholder="Nhập bảng âm thanh">
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
                                                                    class="form-control manufacture"
                                                                    id="exampleInputName1"
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
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Cập nhật</button>
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

                    var inputElement = formElement.querySelector(rule.selector)

                    var errorElement = inputElement.parentElement.querySelector(options.errorSelector);
                    var input = inputElement.parentElement.querySelector('.form-control')
                    console.log(input)

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
        Validator.isStatus = function(selector) {
            return {
                selector,
                test(value) {
                    return value ? undefined : 'Vui lòng nhập số lượng'
                }
            }
        }

        Validator.isDescribe = function(selector) {
            return {
                selector,
                test(value) {
                    return value ? undefined : 'Vui lòng nhập mô tả sản phẩm'
                }
            }
        }

        // Validator.isAvatar = function (selector) {
        //   return {
        //     selector,
        //     test(value) {
        //       return value ? undefined : 'Vui lòng chọn ảnh'
        //     }
        //   }
        // }

        Validator({
            form: '#form-edit-product',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('.fullname'),
                Validator.isList('.list'),
                Validator.isFirm('.firm'),
                Validator.isPrice('.price'),
                Validator.isDiscount('.discount'),
                Validator.isAmount('.amount'),
                Validator.isStatus('.status'),
                Validator.isDescribe('.describe'),
                // Validator.isAvatar('.avatar')
            ],
        })
    </script>
@endsection
