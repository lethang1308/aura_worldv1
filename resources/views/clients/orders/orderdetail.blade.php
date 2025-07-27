@extends('clients.layouts.default')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4" style="font-weight:700; font-size:2rem;">Chi tiết đơn hàng</h2>

        {{-- Hiển thị trạng thái thanh toán --}}
        <div class="mb-3 text-end">
            @if ($order->status_payment === 'paid')
                <span class="badge bg-success px-3 py-2" style="font-size:1rem;">
                    Đã thanh toán
                </span>
            @elseif ($order->status_payment === 'unpaid')
                <span class="badge bg-warning text-dark px-3 py-2" style="font-size:1rem;">
                    Chưa thanh toán
                </span>
            @endif
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm rounded" style="background:#fff;">
                <thead style="background:#4cd964; color:#fff; font-weight:700; text-align:center;">
                    <tr class="text-center align-middle">
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Giá dung tích</th>
                        <th>Số lượng</th>
                        <th>Giá sản phẩm</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->OrderDetail as $i => $detail)
                        @php
                            $product = $detail->variant->product;
                            $image = $product->images->first();
                            $basePrice = $product->base_price ?? 0;
                            $variantPrice = $detail->variant_price ?? 0;
                            $unitPrice = $basePrice + $variantPrice;
                            $totalPrice = $unitPrice * $detail->quantity;
                        @endphp
                        <tr class="text-center align-middle">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $product->name ?? '-' }}</td>
                            <td>
                                @if ($image)
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Product Image"
                                        style="width:80px; height:auto;">
                                @else
                                    <span>Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ number_format($variantPrice, 0, ',', '.') }} đ</td> {{-- Giá dung tích --}}
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($basePrice, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($totalPrice, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tính tổng tiền & phí ship --}}
        <div class="text-end mt-3">
            <p><strong>Phí vận chuyển:</strong> {{ number_format(50000, 0, ',', '.') }} đ</p>
            <h5><strong>Tổng thanh toán:</strong>
                <span class="text-danger" style="font-weight:700;">
                    {{ number_format($order->total_price, 0, ',', '.') }} đ
                </span>
            </h5>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('client.orders') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
        </div>
    </div>
@endsection
