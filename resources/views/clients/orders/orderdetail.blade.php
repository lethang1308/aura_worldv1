@extends('clients.layouts.default')

@section('content')
<!-- Hero Section -->
<section class="banner_area" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content text-center">
                <h2 class="text-black mb-3" style="font-size: 2.5rem; font-weight: 700;">Chi tiết đơn hàng</h2>
                <p class="text-black mb-0" style="font-size: 1.1rem; opacity: 0.9;">Xem chi tiết đơn hàng #{{ $order->id }}</p>
                <div class="d-flex justify-content-center align-items-center mt-4">
                    <a href="/" class="text-black mr-3 text-decoration-none" style="text-decoration: none;">Trang chủ</a>
                    <span class="text-black mr-3">/</span>
                    <a href="{{ route('client.orders') }}" class="text-black mr-3 text-decoration-none" style="text-decoration: none;">Đơn hàng</a>
                    <span class="text-black mr-3 text-decoration-none">/</span>
                    <span class="text-black font-weight-bold text-decoration-none">Chi tiết</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="checkout_area section_gap" style="background-color: #f8f9fa; padding: 60px 0;">
    <div class="container">

        <!-- Order Information Cards -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fa fa-info-circle mr-2"></i>
                            Thông tin đơn hàng
                        </h5>
                        @if ($order->status_order === 'pending')
                        <span class="badge badge-warning px-3 py-2">
                            <i class="fa fa-clock mr-1"></i>CHỜ XÁC NHẬN
                        </span>
                        @elseif($order->status_order === 'confirmed')
                        <span class="badge badge-info px-3 py-2">
                            <i class="fa fa-check mr-1"></i>ĐÃ XÁC NHẬN
                        </span>
                        @elseif($order->status_order === 'shipping')
                        <span class="badge badge-primary px-3 py-2">
                            <i class="fa fa-truck mr-1"></i>ĐANG GIAO HÀNG
                        </span>
                        @elseif($order->status_order === 'shipped')
                        <span class="badge badge-info px-3 py-2">
                            <i class="fa fa-box mr-1"></i>ĐÃ GIAO HÀNG
                        </span>
                        @elseif($order->status_order === 'received')
                        <span class="badge badge-success px-3 py-2">
                            <i class="fa fa-check-circle mr-1"></i>ĐÃ NHẬN HÀNG
                        </span>
                        @elseif($order->status_order === 'completed')
                        <span class="badge badge-success px-3 py-2">
                            <i class="fa fa-star mr-1"></i>HOÀN THÀNH
                        </span>
                        @elseif($order->status_order === 'cancelled')
                        <span class="badge badge-danger px-3 py-2">
                            <i class="fa fa-times mr-1"></i>ĐÃ HỦY
                        </span>
                        @else
                        <span class="badge badge-secondary px-3 py-2">
                            {{ strtoupper($order->status_order) }}
                        </span>
                        @endif
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Mã đơn hàng:</span>
                                <span class="ml-2 text-primary font-weight-bold">#{{ $order->id }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Ngày tạo:</span>
                                <span class="ml-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Trạng thái thanh toán:</span>
                                <span class="ml-2">
                                    @if($order->status_payment === 'paid')
                                    <span class="badge badge-success">Đã thanh toán</span>
                                    @else
                                    <span class="badge badge-warning">Chưa thanh toán</span>
                                    @endif
                                </span>
                            </li>
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Phương thức thanh toán:</span>
                                <span class="ml-2">
                                    @if($order->type_payment == 'cod')
                                    <span class="badge badge-info">Thanh toán khi nhận hàng (COD)</span>
                                    @elseif($order->type_payment == 'vnpay')
                                    <span class="badge badge-primary">Thanh toán qua VNPay</span>
                                    @endif
                                </span>
                            </li>
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Ghi chú:</span>
                                <span class="ml-2">{{ $order->user_note ?? 'Không có ghi chú' }}</span>
                            </li>
                            @if($order->status_order === 'cancelled')
                            <li class="mb-2">
                                <span class="font-weight-bold text-danger">Lý do hủy:</span>
                                <span class="ml-2">{{ $order->cancel_reason ?? 'Không có' }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-user mr-2"></i>
                            Thông tin khách hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Tên khách hàng:</span>
                                <span class="ml-2">{{ $order->user->name ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Email:</span>
                                <span class="ml-2">{{ $order->user_email }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Số điện thoại:</span>
                                <span class="ml-2">{{ $order->user_phone }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Địa chỉ giao hàng:</span>
                                <span class="ml-2">{{ $order->user_address }}</span>
                            </li>
                            @if($order->coupon_code)
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Mã giảm giá:</span>
                                <span class="ml-2">
                                    <span class="badge badge-success">{{ $order->coupon_code }}</span>
                                </span>
                            </li>
                            @endif
                            @if($order->discount > 0)
                            <li class="mb-2">
                                <span class="font-weight-bold text-dark">Giảm giá:</span>
                                <span class="ml-2 text-success">-{{ number_format($order->discount, 0, ',', '.') }} đ</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-shopping-cart mr-2"></i>
                            Danh sách sản phẩm
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr class="text-center">
                                        <th style="width: 5%;">STT</th>
                                        <th style="width: 25%;">Sản phẩm</th>
                                        <th style="width: 20%;">Biến thể</th>
                                        <th style="width: 15%;">Đơn giá</th>
                                        <th style="width: 10%;">Số lượng</th>
                                        <th style="width: 15%;">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->OrderDetail as $i => $detail)
                                    @php
                                    $product = $detail->variant->product ?? null;
                                    $image = $product ? $product->featuredImage : null;
                                    $basePrice = $product ? ($product->base_price ?? 0) : 0;
                                    $variantPrice = $detail->variant_price ?? 0;
                                    $unitPrice = $basePrice + $variantPrice;
                                    $totalPrice = $unitPrice * $detail->quantity;
                                    @endphp
                                    <tr class="text-center align-middle">
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 mr-3">
                                                    @if ($image)
                                                    <img src="{{ asset('storage/' . $image->image) }}"
                                                        alt="{{ $product->name ?? 'Product' }}"
                                                        class="img-fluid rounded"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 50px;">
                                                        <i class="fa fa-image text-white"></i>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1 text-left">
                                                    <strong>{{ $product->name ?? 'Sản phẩm không tồn tại' }}</strong>
                                                    @if($product)
                                                    <br><small class="text-muted">{{ $product->description ?? '' }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($detail->variant)
                                            <span class="badge badge-info">{{ $detail->variant->name ?? 'N/A' }}</span>
                                            @else
                                            <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ number_format($unitPrice, 0, ',', '.') }} đ</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $detail->quantity }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-success">{{ number_format($totalPrice, 0, ',', '.') }} đ</strong>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Order Summary -->
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <!-- Empty space for layout balance -->
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold mb-3">Tổng thanh toán</h6>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <span class="text-muted">Tạm tính:</span>
                                            </div>
                                            <div class="col-6 text-right">
                                                {{ number_format($order->total_price - ($order->discount ?? 0) - 50000, 0, ',', '.') }} đ
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <span class="text-muted">Phí vận chuyển:</span>
                                            </div>
                                            <div class="col-6 text-right">
                                                {{ number_format(50000, 0, ',', '.') }} đ
                                            </div>
                                        </div>
                                        @if($order->discount > 0)
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <span class="text-muted">Giảm giá:</span>
                                            </div>
                                            <div class="col-6 text-right text-success">
                                                -{{ number_format($order->discount, 0, ',', '.') }} đ
                                            </div>
                                        </div>
                                        @endif
                                        <hr>
                                        <div class="row">
                                            <div class="col-6">
                                                <h6 class="font-weight-bold">Tổng cộng:</h6>
                                            </div>
                                            <div class="col-6 text-right">
                                                <h6 class="font-weight-bold text-danger">
                                                    {{ number_format($order->total_price, 0, ',', '.') }} đ
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('client.orders') }}" class="btn btn-secondary mr-2">
                    <i class="fa fa-arrow-left mr-2"></i>Quay lại danh sách
                </a>
                @if ($order->status_order === 'pending')
                <button type="button" class="btn btn-danger" onclick="showCancelModal({{ $order->id }})">
                    <i class="fa fa-times mr-2"></i>Hủy đơn hàng
                </button>
                @endif
                @if ($order->status_order === 'received')
                <button type="button" class="btn btn-success" onclick="completeOrder({{ $order->id }})">
                    <i class="fa fa-check mr-2"></i>Hoàn thành đơn hàng
                </button>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Modal nhập lý do hủy đơn -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="cancelOrderForm" method="POST" action="{{ route('client.orders.cancel') }}">
            @csrf
            <input type="hidden" name="order_id" id="cancel_order_id">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        Hủy đơn hàng #{{ $order->id }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-info-circle mr-2"></i>
                        <strong>Lưu ý:</strong> Bạn chỉ có thể hủy đơn hàng khi đơn hàng đang ở trạng thái "Chờ xác nhận"
                    </div>
                    <div class="form-group">
                        <label for="cancel_reason" class="font-weight-bold">Lý do hủy đơn:</label>
                        <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="4"
                            required placeholder="Nhập lý do hủy đơn hàng..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times mr-1"></i>Đóng
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-check mr-1"></i>Xác nhận hủy
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function showCancelModal(orderId) {
        document.getElementById('cancel_order_id').value = orderId;
        var myModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
        myModal.show();
    }

    function completeOrder(orderId) {
        if (confirm('Bạn có chắc chắn muốn hoàn thành đơn hàng này?')) {
            // Gửi request hoàn thành đơn hàng
            fetch(`/clients/orders/${orderId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Đơn hàng đã được hoàn thành!');
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi hoàn thành đơn hàng');
                });
        }
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush

<style>
    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-info {
        background-color: #17a2b8;
        color: white;
    }

    .badge-primary {
        background-color: #007bff;
        color: white;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-danger {
        background-color: #dc3545;
        color: white;
    }

    .badge-secondary {
        background-color: #6c757d;
        color: white;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .table td {
        vertical-align: middle;
    }

    .list-unstyled li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .list-unstyled li:last-child {
        border-bottom: none;
    }
</style>