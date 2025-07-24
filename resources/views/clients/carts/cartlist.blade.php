@extends('clients.layouts.default')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}<br>
        Mã đơn hàng: {{ session('order_id') }}<br>
        Mã giao dịch: {{ session('transaction_id') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}<br>
        @if(session('order_id'))
            Mã đơn hàng: {{ session('order_id') }}<br>
        @endif
        @if(session('transaction_id'))
            Mã giao dịch: {{ session('transaction_id') }}
        @endif
    </div>
@endif
    <!--================Home Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Cart</h2>
                        <p>Your selected products</p>
                    </div>
                    <div class="page_link">
                        <a href="{{ route('client.home') }}">Home</a>
                        <a href="#">Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
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
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $subtotal = 0; @endphp
                                @foreach ($cart->cartItem as $item)
                                    @php
                                        $product = $item->variant->product;
                                        $price = $item->variant->price ?? $product->base_price;
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
                                            <h5>${{ number_format($price, 2) }}</h5>
                                        </td>
                                        <td>
                                            <div class="product_count d-flex align-items-center">
                                                <input
                                                    type="number"
                                                    value="{{ $item->quantity }}"
                                                    min="1"
                                                    class="input-text qty mr-2 update-cart"
                                                    data-url="{{ route('client.carts.update', $item->id) }}"
                                                    data-item-id="{{ $item->id }}"
                                                    style="width: 60px"
                                                >
                                            </div>
                                        </td>
                                        <td>
                                            <h5 class="item-total-{{ $item->id }}">${{ number_format($total, 2) }}</h5>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('client.carts.delete', $item->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td>
                                        <h5 id="cart-subtotal">${{ number_format($subtotal, 2) }}</h5>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="out_button_area">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="checkout_btn_inner">
                                            <a class="gray_btn" href="{{ route('client.home') }}">Continue Shopping</a>
                                            <a class="main_btn" href="{{ route('client.carts.checkout') }}">Proceed to Checkout</a>
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
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.update-cart').forEach(input => {
                input.addEventListener('change', function () {
                    const itemId = this.dataset.itemId;
                    const url = this.dataset.url;
                    const quantity = this.value;

                    fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ quantity: quantity })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật tổng cho sản phẩm
                            document.querySelector(`.item-total-${itemId}`).innerText = `$${data.total}`;

                            // Cập nhật tổng phụ
                            document.getElementById('cart-subtotal').innerText = `$${data.subtotal}`;
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
        });
    </script>
@endsection
