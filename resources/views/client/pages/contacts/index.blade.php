@extends('client.master')
@section('title', 'Danh mục')
@section('content')
    <!--================Home Banner Area =================-->
    <section class="section_gap">
        <div class="container">
            <div class="row">
                <!-- Bannel -->
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title text-center">Liên hệ chúng tôi</h2>
                </div>
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <form class="form-contact contact_form" action="/addContact" method="post" id="form-register"
                        novalidate="novalidate">
                        @csrf
                        <div class="row">
                            @if (isset($dataUser))
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control w-100 message" name="message" cols="30" rows="9"
                                            placeholder="Nhập tin nhắn..." required></textarea>
                                        <span style="font-size: 15px; color: #f33a58;width: 100%;"
                                            class="form-message"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" name="name" id="" type="text"
                                            value="{{ $dataUser->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" name="email" id="" type="email"
                                            value="{{ $dataUser->email }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group mt-lg-3">
                                    <button type="submit" class="main_btn">Gửi tin nhắn.</button>
                                    <button class="main_btn" type="button" data-toggle="collapse"
                                        data-target="#collapseExample2" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        Lịch sử liên hệ
                                    </button>
                                </div>
                            @endif
                        </div>

                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>137 - Nguyễn Thị Thập - Thanh Khê- Đà Nẵng</h3>
                            <p>Đà Nẵng</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3><a href="tel:454545654">0796.69.2773</a></h3>
                            <p>Thứ Hai đến Thứ Sáu, 9 giờ sáng đến 6 giờ chiều.</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3><a href="#">Guitarlist@gmail.com</a></h3>
                            <p>Gửi cho chúng tôi câu hỏi của bạn bất cứ lúc nào!.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse" id="collapseExample2">
                <div class="card card-body" style="border: none;">
                    <section class="cart_area" style="padding-top: 0px; padding-bottom: 0px">
                        <div class="container">
                            <div class="row">
                                <div class="cart_inner col-md-12">
                                    <div class="table-responsive">
                                        <table class="table cart-table">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-2" scope="col">Tên người dùng </th>
                                                    <th class="col-md-6" scope="col">Nội dung</th>
                                                    <th class="col-md-2" scope="col">Thời gian</th>
                                                    <th class="col-md-2" scope="col">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if (isset($viewContacts) && count($viewContacts) > 0)
                                                    @foreach ($viewContacts as $viewCon)
                                                        <tr>
                                                            <td>{{ $viewCon->user_name }}</td>
                                                            <td>{!! $viewCon->message !!}</td>
                                                            <td>{{ $viewCon->created_at }}</td>

                                                            <td>
                                                                @if ($viewCon->status == 0)
                                                                    <a href="{{ route('deleteContact', $viewCon->id) }}"
                                                                        onclick="confirm('Bạn chắc chắn xoá tin nhắn này')"
                                                                        class="genric-btn danger-border radius delete-cart"><i
                                                                            class="fa fa-times" aria-hidden="true"></i></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">
                                                            <p class="no_cart">Bạn chưa có lịch sử liên hệ nào</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Modal title</h4>
                            </div>
                            <div class="modal-body">
                                <p>One fine body&hellip;</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>

            <div class= 'row' style="margin-bottom: 100px; ">
                <div class="col-lg-6">
                    <div id="map" style=" width: 100%; height: 380px; float: left; ">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2236.1374988314938!2d108.16966138988002!3d16.07428885033731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314218e6e07b1c3f%3A0x459e4bf5a2af323e!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYyDEkMOgIE7hurVuZw!5e0!3m2!1svi!2s!4v1664677507528!5m2!1svi!2s"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div id="map" style=" width: 100%; height: 380px;  float: right; ">
                        <iframe width="100%" height="100%"
                            src="https://www.youtube.com/embed/b3AnX43m-gw?si=8HTcidlY17V_e7jl"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                    </div>
                </div>
                <script>
                    function initMap() {
                        var uluru = {
                            lat: -25.363,
                            lng: 131.044
                        };
                        var grayStyles = [{
                                featureType: "all",
                                stylers: [{
                                        saturation: -90
                                    },
                                    {
                                        lightness: 50
                                    }
                                ]
                            },
                            {
                                elementType: 'labels.text.fill',
                                stylers: [{
                                    color: '#A3A3A3'
                                }]
                            }
                        ];
                        var map = new google.maps.Map(document.getElementById('map'), {
                            center: {
                                lat: -31.197,
                                lng: 150.744
                            },
                            zoom: 9,
                            styles: grayStyles,
                            scrollwheel: false
                        });
                    }
                </script>
                <script
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2236.1374988314938!2d108.16966138988002!3d16.07428885033731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314218e6e07b1c3f%3A0x459e4bf5a2af323e!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYyDEkMOgIE7hurVuZw!5e0!3m2!1svi!2s!4v1664677507528!5m2!1svi!2s">
                </script>
                <!-- </div> -->
            </div>
        </div>

    </section>
    <!--================ End Blog Area =================-->
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
                    return value.trim() ? undefined : 'Vui lòng nhập nội dung'
                }
            }
        }



        Validator({
            form: '#form-register',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('.message')
            ],
        })
    </script>
@endsection
