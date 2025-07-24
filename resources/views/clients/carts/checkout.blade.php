    @extends('clients.layouts.default')

    @section('content')
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(
            isset(
                $errors
            ) && $errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section class="banner_area">
            <div class="banner_inner d-flex align-items-center">
                <div class="container">
                    <div class="banner_content d-md-flex justify-content-between align-items-center">
                        <div class="mb-3 mb-md-0">
                            <h2>Thanh toán đơn hàng</h2>
                            <p>Hoàn tất thông tin để đặt hàng nhanh chóng!</p>
                        </div>
                        <div class="page_link">
                            <a href="/">Trang chủ</a>
                            <a href="#">Thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Home Banner Area =================-->

        <!--================Checkout Area =================-->
        <section class="checkout_area section_gap">
            <div class="container">
                <div class="cupon_area">
                    <input type="text" placeholder="Nhập mã giảm giá" />
                    <a class="tp_btn" href="#">Áp dụng mã</a>
                </div>
                <div class="billing_details">
                    <form class="row contact_form" action="{{ route('client.carts.placeOrder') }}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="col-lg-8">
                            <h3>Thông tin thanh toán</h3>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="last" name="name" placeholder="Họ và tên *" />
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="number" name="number" placeholder="Số điện thoại *" />
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email *" />
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="add1" name="add1" placeholder="Địa chỉ nhận hàng *" />
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="city" name="city" placeholder="Tỉnh/Thành phố *" />
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <select class="country_select" name="district">
                                    <option value="1">Quận/Huyện</option>
                                    <option value="2">Quận/Huyện</option>
                                    <option value="4">Quận/Huyện</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option2" name="create_account" />
                                    <label for="f-option2">Tạo tài khoản mới?</label>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea class="form-control" name="message" id="message" rows="1" placeholder="Ghi chú đơn hàng"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="order_box">
                                <h2>Đơn hàng của bạn</h2>
                                <ul class="list">
                                    <li>
                                        <a href="#">Sản phẩm mẫu
                                            <span class="middle">x 02</span>
                                            <span class="last">720.000đ</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="list list_2">
                                    <li>
                                        <a href="#">Tạm tính
                                            <span>2.160.000đ</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Phí vận chuyển
                                            <span>50.000đ</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Tổng cộng
                                            <span>2.210.000đ</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="payment_item">
                                    <div class="radion_btn">
                                        <input type="radio" id="payment_cod" name="payment_method" value="cod" checked />
                                        <label for="payment_cod">Thanh toán khi nhận hàng (COD)</label>
                                        <div class="check"></div>
                                    </div>
                                </div>
                                <div class="payment_item">
                                    <div class="radion_btn">
                                        <input type="radio" id="payment_paypal" name="payment_method" value="paypal" />
                                        <label for="payment_paypal">Thanh toán qua Paypal</label>
                                        <img src="img/product/single-product/card.jpg" alt="" />
                                        <div class="check"></div>
                                    </div>
                                    <p>
                                        Vui lòng chuyển khoản hoặc thanh toán qua Paypal theo hướng dẫn.
                                    </p>
                                </div>
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option4" name="accept_terms" />
                                    <label for="f-option4">Tôi đã đọc và đồng ý với </label>
                                    <a href="#">điều khoản & chính sách*</a>
                                </div>
                                <button type="submit" class="main_btn">Đặt hàng</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    @endsection
