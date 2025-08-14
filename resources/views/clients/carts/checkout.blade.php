@extends('clients.layouts.default')

@section('content')
@php
$user = Auth::user();
$coupon = session('applied_coupon');
$discount = $coupon['discount'] ?? 0;
$shipping = 50000;
$cartTotal = $cart->total_price ?? 0;
$finalTotal = $cartTotal + $shipping - $discount;
@endphp

<!-- Hero Section -->
<section class="banner_area" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content text-center">
                <h2 class="text-white mb-3" style="font-size: 2.5rem; font-weight: 700;">Thanh toán đơn hàng</h2>
                <p class="text-white mb-0" style="font-size: 1.1rem; opacity: 0.9;">Hoàn tất thông tin để đặt hàng nhanh chóng và an toàn</p>
                <div class="d-flex justify-content-center align-items-center mt-4">
                    <a href="/" class="text-white mr-3" style="text-decoration: none;">Trang chủ</a>
                    <span class="text-white mr-3">/</span>
                    <span class="text-white font-weight-bold">Thanh toán</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Checkout Section -->
<section class="checkout_area section_gap" style="background-color: #f8f9fa; padding: 60px 0; margin-top: 0;">
    <div class="container">

        <!-- Notifications -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fa fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fa fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fa fa-exclamation-triangle mr-2"></i>
            <strong>Có lỗi xảy ra:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="row">

            <!-- Left Column - Checkout Form -->
            <div class="col-lg-8">

                <!-- Coupon Section -->
                <div class="card mb-4 shadow-sm checkout-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fa fa-tag text-success mr-2"></i>
                            Mã giảm giá
                        </h5>
                        <form id="coupon-form" class="row">
                            @csrf
                            <div class="col-md-6">
                                <input type="text"
                                    name="coupon_code"
                                    id="coupon_code"
                                    placeholder="Nhập mã giảm giá của bạn"
                                    class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fa fa-check mr-1"></i>Áp dụng
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="remove-coupon-btn" class="btn btn-danger btn-block">
                                    <i class="fa fa-times mr-1"></i>Huỷ mã
                                </button>
                            </div>
                        </form>
                        <div id="coupon-message" class="mt-3"></div>
                    </div>
                </div>

                <div class="billing_details">
                    <form class="row contact_form" action="{{ route('client.carts.placeOrder') }}" method="POST" novalidate>
                        @csrf

                        {{-- FORM THÔNG TIN --}}
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

                        <!-- Right Column - Order Summary -->
                        <div class="col-lg-4">
                            <div class="card shadow-sm order-summary-card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">
                                        <i class="fa fa-shopping-cart text-warning mr-2"></i>
                                        Đơn hàng của bạn
                                    </h5>

                                    <!-- Order Items -->
                                    <div class="mb-4">
                                        @foreach ($cart->cartItem as $item)
                                        @php
                                        $product = $item->variant->product ?? null;
                                        $variant = $item->variant;
                                        $name = $product ? $product->name : 'Sản phẩm';
                                        $variantName = $variant && $variant->name ? ' - ' . $variant->name : '';
                                        $basePrice = floatval($product->base_price ?? 0);
                                        $variantPrice = floatval($variant->price ?? 0);
                                        $unitPrice = $basePrice + $variantPrice;
                                        $lineTotal = $unitPrice * $item->quantity;
                                        @endphp
                                        <div class="d-flex align-items-center p-3 bg-light rounded mb-2">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="bg-secondary rounded" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                                    @if($product && $product->featuredImage)
                                                    <img src="{{ asset('storage/' . $product->featuredImage->image) }}"
                                                        alt="{{ $name }}"
                                                        class="img-fluid rounded" style="max-width: 100%; max-height: 100%; object-fit: cover;" />
                                                    @else
                                                    <i class="fa fa-image text-muted"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 min-width-0">
                                                <p class="font-weight-bold text-truncate mb-1">{{ $name . $variantName }}</p>
                                                <p class="text-muted mb-0">Số lượng: {{ $item->quantity }}</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="font-weight-bold text-primary">{{ number_format($lineTotal, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <!-- Order Summary -->
                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Tạm tính</span>
                                            <span class="font-weight-bold">{{ number_format($cartTotal, 0, ',', '.') }}đ</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Giảm giá</span>
                                            <span class="font-weight-bold text-success" id="discount-amount">-{{ number_format($discount, 0, ',', '.') }}đ</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="text-muted">Phí vận chuyển</span>
                                            <span class="font-weight-bold">{{ number_format($shipping, 0, ',', '.') }}đ</span>
                                        </div>
                                        <div class="border-top pt-3">
                                            <div class="d-flex justify-content-between">
                                                <span class="h5 font-weight-bold">Tổng cộng</span>
                                                <span class="h5 font-weight-bold text-primary" id="total-amount">{{ number_format($finalTotal, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="creat_account">
                                        <input type="checkbox" id="f-option4" name="accept_terms" />
                                        <label for="f-option4">Tôi đã đọc và đồng ý với </label>
                                        <a href="#">điều khoản & chính sách*</a>
                                    </div>

                                    <button type="submit" class="main_btn">Đặt hàng</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
</section>

{{-- AJAX Scripts --}}
<script>
    // Coupon functionality
    document.getElementById('coupon-form').addEventListener('submit', function(e) {
        e.preventDefault();
        let code = document.getElementById('coupon_code').value;

        fetch('{{ route('
                client.carts.useCoupon ') }}', {
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
                    document.getElementById('discount-amount').innerText = '-' + res.formatted_discount + 'đ';
                    document.getElementById('total-amount').innerText = res.total + 'đ';
                }
            });
    });

    document.getElementById('remove-coupon-btn').addEventListener('click', function() {
        fetch('{{ route('
                client.carts.removeCoupon ') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
            .then(res => res.json())
            .then(res => {
                const msgBox = document.getElementById('coupon-message');
                msgBox.innerHTML = `<div class="alert alert-warning">${res.success}</div>`;
                document.getElementById('discount-amount').innerText = '-0đ';
                document.getElementById('total-amount').innerText = res.total + 'đ';
                document.getElementById('coupon_code').value = '';
            });
    });

    // Check điều khoản
    document.querySelector('form.contact_form').addEventListener('submit', function(e) {
        if (!document.getElementById('f-option4').checked) {
            e.preventDefault();
            alert('Vui lòng đồng ý với điều khoản & chính sách trước khi đặt hàng.');
        }
    });

    setInterval(() => {
        fetch('{{ route('
                client.carts.recalculate ') }}')
            .then(res => res.json())
            .then(data => {
                if (!data || !data.items) return;

                data.items.forEach((item, index) => {
                    const rows = document.querySelectorAll('.order-summary .order-item');
                    if (rows[index]) {
                        const priceElement = rows[index].querySelector('.item-price');
                        if (priceElement) {
                            priceElement.innerText = item.line_total;
                        }
                    }
                });

                // Update totals
                const subtotalElement = document.querySelector('.order-summary .subtotal');
                const shippingElement = document.querySelector('.order-summary .shipping');
                const totalElement = document.querySelector('.order-summary .total');

                if (subtotalElement) subtotalElement.innerText = data.subtotal;
                if (shippingElement) shippingElement.innerText = data.shipping;
                if (totalElement) totalElement.innerText = data.total;
            });
    }, 10000);
</script>

<style>
    /* Fix layout issues */
    .checkout_area {
        position: relative;
        z-index: 1;
    }

    .checkout-card {
        position: relative;
        z-index: 2;
        margin-bottom: 20px;
    }

    .order-summary-card {
        position: relative;
        z-index: 2;
    }

    .payment-methods-card {
        position: relative;
        z-index: 2;
    }

    /* Ensure cards don't overlap with header */
    .card {
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: 0.375rem;
        background: #fff;
        position: relative;
    }

    .card-body {
        padding: 1.25rem;
        position: relative;
    }

    /* Remove sticky positioning that might cause overlap */
    .sticky-top {
        position: relative;
        top: auto;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .checkout_area {
            padding: 30px 0;
        }

        .card-body {
            padding: 1rem;
        }
    }

    /* Payment method card improvements */
    .payment-method-card {
        transition: all 0.3s ease;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .payment-method-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .payment-method-card input[type="radio"]:checked+div {
        border-color: #007bff !important;
        background-color: #f8f9fa;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .min-width-0 {
        min-width: 0;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Form improvements */
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    /* Ensure proper spacing */
    .banner_area {
        margin-bottom: 0;
    }

    .section_gap {
        margin-top: 0;
    }
</style>
@endsection