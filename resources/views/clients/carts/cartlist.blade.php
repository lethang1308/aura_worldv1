@extends('clients.layouts.default')

@section('content')
<!--================Home Banner Area =================-->
<section class="banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content d-md-flex justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <h2>Giỏ hàng</h2>
                    <p>Sản phẩm bạn đã chọn</p>
                </div>
                <div class="page_link">
                    <a href="{{ route('client.home') }}">Trang chủ</a>
                    <a href="#">Giỏ hàng</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Home Banner Area =================-->

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div id="price-update-message" class="text-success mb-2 font-weight-bold"></div>

        @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif

        @if (!empty($cart) && $cart->cartItem && $cart->cartItem->count() > 0)
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach ($cart->cartItem as $item)
                        @php
                        $variant = $item->variant;
                        $product = $variant?->product;
                        @endphp

                        @if (!$variant || !$product)
                        <tr>
                            <td colspan="5">
                                <div class="alert alert-warning mb-0">
                                    ⚠️ Sản phẩm này không còn tồn tại trong hệ thống.
                                    <form method="POST" action="{{ route('client.carts.delete', $item->id) }}" class="d-inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xoá khỏi giỏ</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @continue
                        @endif

                        @php
                        $basePrice = $product->base_price ?? 0;
                        $variantPrice = $variant->price ?? 0;
                        $price = $basePrice + $variantPrice;
                        $total = $price * $item->quantity;
                        $subtotal += $total;

                        $image = $product->images->first()
                        ? asset('storage/' . $product->images->first()->path)
                        : 'https://via.placeholder.com/100';
                        @endphp
                        <tr>
                            <td>
                                <div class="media">
                                    <img src="{{ $image }}" alt="" width="80">
                                    <div class="media-body pl-3">
                                        <p>{{ $product->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5 class="unit-price-{{ $item->id }}">
                                    {{ number_format($price, 0, ',', '.') }}₫
                                </h5>
                            </td>
                            <td>
                                <div class="product_count d-flex align-items-center">
                                    <input type="number" value="{{ $item->quantity }}" min="1"
                                        class="input-text qty mr-2 update-cart"
                                        data-url="{{ route('client.carts.update', $item->id) }}"
                                        data-item-id="{{ $item->id }}" style="width: 60px">
                                </div>
                            </td>
                            <td>
                                <h5 class="item-total-{{ $item->id }}">
                                    {{ number_format($total, 0, ',', '.') }}₫
                                </h5>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('client.carts.delete', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xoá</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right">
                                <h5>Tạm tính</h5>
                            </td>
                            <td>
                                <h5 id="cart-subtotal">{{ number_format($subtotal, 0, ',', '.') }}₫</h5>
                            </td>
                            <td></td>
                        </tr>
                        <tr class="out_button_area">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="checkout_btn_inner">
                                    <a class="gray_btn" href="{{ route('client.home') }}">Tiếp tục mua sắm</a>
                                    <a class="main_btn" href="{{ route('client.carts.checkout') }}">Thanh toán</a>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="text-center mt-5">
            <h4>🛒 Giỏ hàng trống</h4>
        </div>
        @endif
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function formatVND(number) {
            return Number(number).toLocaleString('vi-VN') + '₫';
        }

        // Thay đổi số lượng
        document.querySelectorAll('.update-cart').forEach(input => {
            input.addEventListener('change', function() {
                const itemId = this.dataset.itemId;
                const url = this.dataset.url;
                const quantity = parseInt(this.value);

                if (isNaN(quantity) || quantity < 1) {
                    alert('Số lượng không hợp lệ.');
                    return;
                }

                fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`.item-total-${itemId}`).innerText = formatVND(data.total);
                            document.getElementById('cart-subtotal').innerText = formatVND(data.subtotal);
                        } else {
                            alert('Đã có lỗi xảy ra khi cập nhật.');
                        }
                    })
                    .catch(err => {
                        alert('Lỗi kết nối đến server.');
                        console.error(err);
                    });
            });
        });

        // 🕒 Tự động cập nhật giá mỗi 10 giây
        setInterval(() => {
            fetch('{{ route('client.carts.recalculate') }}', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                .then(res => res.json())
                .then(res => {
                    if (!res || !res.items) return;
                    res.items.forEach(item => {
                        const unitEl = document.querySelector(`.unit-price-${item.id}`);
                        const lineEl = document.querySelector(`.item-total-${item.id}`);
                        if (unitEl) unitEl.innerText = item.unit_price;
                        if (lineEl) lineEl.innerText = item.line_total;
                    });
                    const sub = document.getElementById('cart-subtotal');
                    if (sub) sub.innerText = res.subtotal;

                    const notify = document.getElementById('price-update-message');
                    if (notify) {
                        notify.innerText = '✅ Giá sản phẩm đã được cập nhật';
                        setTimeout(() => notify.innerText = '', 3000);
                    }
                });
        }, 10000);
    });
</script>
@endsection