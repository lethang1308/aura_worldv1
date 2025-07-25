@extends('clients.layouts.default')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $user = Auth::user();
        $coupon = session('applied_coupon');
        $discount = $coupon['discount'] ?? 0;
    @endphp

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

    <section class="checkout_area section_gap">
        <div class="container">

            {{-- Form mã giảm giá --}}
            <div class="cupon_area">
                <form id="coupon-form">
                    @csrf
                    <input type="text" name="coupon_code" id="coupon_code" placeholder="Nhập mã giảm giá" />
                    <button type="submit" class="tp_btn ml-2">Áp dụng mã</button>
                    <button type="button" id="remove-coupon-btn" class="tp_btn ml-2 btn-danger">Huỷ mã</button>
                </form>
                <div id="coupon-message" class="mt-2"></div>
            </div>

            <div class="billing_details">
                <form class="row contact_form" action="{{ route('client.carts.placeOrder') }}" method="post"
                    novalidate="novalidate">
                    @csrf
                    <div class="col-lg-8">
                        <h3>Thông tin thanh toán</h3>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" name="name" placeholder="Họ và tên *"
                                value="{{ old('name', $user->name ?? '') }}" />
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" name="number" placeholder="Số điện thoại *"
                                value="{{ old('number', $user->phone ?? '') }}" />
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" name="email" placeholder="Email *"
                                value="{{ old('email', $user->email ?? '') }}" />
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" name="add1" placeholder="Địa chỉ nhận hàng *"
                                value="{{ old('add1', $user->address ?? '') }}" />
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" name="city" placeholder="Tỉnh/Thành phố *" />
                        </div>
                        <div class="col-md-12 form-group">
                            <textarea class="form-control" name="message" rows="1" placeholder="Ghi chú đơn hàng">{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="order_box">
                            <h2>Đơn hàng của bạn</h2>
                            <ul class="list">
                                @if ($cart && $cart->cartItem->count())
                                    @foreach ($cart->cartItem as $item)
                                        <li>
                                            <a href="#">
                                                {{ $item->variant->product->name ?? 'Sản phẩm' }}
                                                <span class="middle">x {{ $item->quantity }}</span>
                                                <span class="last">
                                                    {{ number_format(($item->variant->price ?? 0) * $item->quantity, 0, ',', '.') }}đ
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li><span>Giỏ hàng trống</span></li>
                                @endif
                            </ul>

                            <ul class="list list_2">
                                <li>
                                    <a href="#">Tạm tính
                                        <span>{{ number_format($cart->total_price ?? 0, 0, ',', '.') }}đ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">Giảm giá
                                        <span id="discount-amount">-{{ number_format($discount, 0, ',', '.') }}đ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">Phí vận chuyển
                                        <span>50.000đ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">Tổng cộng
                                        <span id="total-amount">
                                            {{ number_format(($cart->total_price ?? 0) + 50000 - $discount, 0, ',', '.') }}đ
                                        </span>
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
                                    <input type="radio" id="payment_vnpay" name="payment_method" value="vnpay" />
                                    <label for="payment_vnpay">Thanh toán qua VNPay</label>
                                    <img src="{{ asset('client/assets/img/ft_banner2.png') }}" alt="VNPay"
                                        style="max-width: 65px;"/>
                                    <div class="check"></div>
                                </div>
                                <p>Bạn sẽ được chuyển đến cổng thanh toán VNPay để hoàn tất giao dịch.</p>
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

    {{-- AJAX Script --}}
    <script>
        document.getElementById('coupon-form').addEventListener('submit', function(e) {
            e.preventDefault();
            let code = document.getElementById('coupon_code').value;

            fetch('{{ route('client.carts.useCoupon') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        coupon_code: code
                    })
                })
                .then(res => res.json())
                .then(res => {
                    const msgBox = document.getElementById('coupon-message');
                    if (res.error) {
                        msgBox.innerHTML = `<div class="alert alert-danger">${res.error}</div>`;
                    } else {
                        msgBox.innerHTML = `<div class="alert alert-success">${res.success}</div>`;
                        document.getElementById('discount-amount').innerText = '-' + res.formatted_discount +
                            'đ';
                        document.getElementById('total-amount').innerText = res.total + 'đ';
                    }
                })
                .catch(err => {
                    document.getElementById('coupon-message').innerHTML =
                        `<div class="alert alert-danger">Lỗi hệ thống.</div>`;
                });
        });

        document.getElementById('remove-coupon-btn').addEventListener('click', function() {
            fetch('{{ route('client.carts.removeCoupon') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(res => res.json())
                .then(res => {
                    const msgBox = document.getElementById('coupon-message');
                    if (res.error) {
                        msgBox.innerHTML = `<div class="alert alert-danger">${res.error}</div>`;
                    } else {
                        msgBox.innerHTML = `<div class="alert alert-warning">${res.success}</div>`;
                        document.getElementById('discount-amount').innerText = '-' + res.formatted_discount +
                            'đ';
                        document.getElementById('total-amount').innerText = res.total + 'đ';
                        document.getElementById('coupon_code').value = '';
                    }
                })
                .catch(err => {
                    document.getElementById('coupon-message').innerHTML =
                        `<div class="alert alert-danger">Lỗi hệ thống.</div>`;
                });
        });
    </script>
    <style>
        .order_box ul.list li a {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order_box ul.list li a .middle {
            margin-left: auto;
            margin-right: 10px;
            white-space: nowrap;
        }

        .order_box ul.list li a .last {
            white-space: nowrap;
        }
    </style>
@endsection
