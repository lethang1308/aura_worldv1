@extends('clients.layouts.default')

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Chi tiết đơn hàng</h3>
        <div class="row">
            {{-- Thông tin đơn hàng --}}
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="mb-0">Thông tin đơn hàng</h5>
                        @if ($order->status_order === 'pending')
                            <span class="badge text-warning">Chưa xác nhận</span>
                        @elseif ($order->status_order === 'confirmed')
                            <span class="badge text-primary">Đã xác nhận</span>
                        @elseif ($order->status_order === 'shipping')
                            <span class="badge text-info">Đang giao hàng</span>
                        @elseif ($order->status_order === 'shipped')
                            <span class="badge text-secondary">Đã giao hàng</span>
                        @elseif ($order->status_order === 'received')
                            <span class="badge text-success">Đã nhận hàng</span>
                        @elseif ($order->status_order === 'completed')
                            <span class="badge text-success">Hoàn thành</span>
                        @elseif ($order->status_order === 'cancelled')
                            <span class="badge text-danger">Đã huỷ</span>
                        @else
                            <span class="badge text-muted">{{ strtoupper($order->status_order) }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><strong>Mã đơn:</strong> #{{ $order->id }}</li>
                            <li><strong>Ngày tạo:</strong>
                                {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}</li>
                            <li>
                                <strong>Trạng thái thanh toán:</strong>
                                @if ($order->status_payment === 'paid')
                                    <span class="text-success fw-bold">Đã thanh toán</span>
                                @elseif($order->status_payment === 'unpaid')
                                    <span class="text-warning fw-bold">Chờ xác nhận</span>
                                @else
                                    <span class="text-muted">Không xác định</span>
                                @endif
                            </li>
                            <li><strong>Ghi chú:</strong> {{ $order->user_note ?? 'Không có' }}</li>
                            @if ($order->status_order === 'cancelled')
                                <li class="text-danger"><strong>Lý do huỷ:</strong>
                                    {{ $order->cancel_reason ?? 'Không có' }}</li>
                            @endif
                            <li><strong>Phương thức thanh toán:</strong>
                                @if ( $order->type_payment === 'cod')
                                Thanh toán khi nhận hàng
                                @elseif ( $order->type_payment === 'vnpay')
                                Thanh toán bằng VNPAY
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Thông tin khách hàng --}}
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><strong>Tài khoản:</strong> {{ $order->user->name ?? 'N/A' }}</li>
                            <li><strong>Email:</strong> {{ $order->user_email }}</li>
                            <li><strong>SĐT:</strong> {{ $order->user_phone }}</li>
                            <li><strong>Địa chỉ:</strong> {{ $order->user_address }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Danh sách sản phẩm --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Danh sách sản phẩm</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Sản phẩm</th>
                            <th>Biến thể</th>
                            <th>Giá biến thể</th>
                            <th>Giá sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->OrderDetail as $i => $detail)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    @if ($detail->variant && $detail->variant->product)
                                        <a href="{{ route('client.products.show', $detail->variant->product->id) }}">
                                            {{ $detail->variant->product->name }}
                                        </a>
                                    @else
                                        Sản phẩm đã bị xóa
                                    @endif
                                </td>
                                <td>Mã biến thể: {{ $detail->variant_id }}</td>
                                <td>
                                    {{ number_format($detail->variant_price, 0, ',', '.') }} đ
                                    @if ($detail->variant->product && $detail->variant->product->base_price > $detail->variant_price)
                                    @endif
                                </td>
                                <td>
                                    {{ $detail->variant->product ? number_format($detail->variant->product->base_price, 0, ',', '.') . ' đ' : 'N/A' }}
                                </td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->total_price, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-end mt-3">
                    <div>Phí ship: <strong>{{ number_format(50000, 0, ',', '.') }} đ</strong></div>
                    <div>Giảm giá: <strong>-{{ number_format($order->discount ?? 0, 0, ',', '.') }} đ</strong></div>
                    <h5 class="mt-2">Tổng tiền: <span
                            class="text-danger">{{ number_format($order->total_price, 0, ',', '.') }} đ</span></h5>
                </div>
            </div>
        </div>

        {{-- Nút quay lại --}}
        <div>
            <a href="{{ route('client.orders') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
@endsection
