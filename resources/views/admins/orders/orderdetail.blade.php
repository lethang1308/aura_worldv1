@extends('admins.layouts.default')

@section('content')
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mx-auto mb-3" role="alert" style="max-width: 700px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 16px 24px; text-align: center; font-size: 17px;">
        {{ session('error') }}
        <button type="button" class="btn-close position-absolute end-0 me-3 mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mx-auto mb-3" role="alert" style="max-width: 700px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 16px 24px; text-align: center; font-size: 17px;">
        {{ session('success') }}
        <button type="button" class="btn-close position-absolute end-0 me-3 mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Thông tin đơn hàng</h4>
                            <span class="badge bg-info fs-14">{{ $statusList[$order->status_order] ?? $order->status_order }}</span>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled fs-15 mb-0">
                                <li><span class="fw-medium text-dark">Mã đơn:</span> <span class="mx-2">#{{ $order->id }}</span></li>
                                <li><span class="fw-medium text-dark">Ngày tạo:</span> <span class="mx-2">
                                    @if($order->created_at)
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    @else
                                        N/A
                                    @endif
                                </span></li>
                                <li><span class="fw-medium text-dark">Trạng thái thanh toán:</span> <span class="mx-2">
                                    @if($order->status_payment === 'paid')
                                        <span class="badge bg-success">Đã thanh toán</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                    @endif
                                </span></li>
                                <li><span class="fw-medium text-dark">Ghi chú:</span> <span class="mx-2">{{ $order->user_note }}</span></li>
                                @if($order->status_order === 'cancelled')
                                    <li><span class="fw-medium text-danger">Lý do huỷ:</span> <span class="mx-2">{{ $order->cancel_reason ?? 'Không có' }}</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Thông tin khách hàng</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled fs-15 mb-0">
                                <li><span class="fw-medium text-dark">Tài khoản:</span> <span class="mx-2">{{ $order->user->name ?? 'N/A' }}</span></li>
                                <li><span class="fw-medium text-dark">Email:</span> <span class="mx-2">{{ $order->user_email }}</span></li>
                                <li><span class="fw-medium text-dark">SĐT:</span> <span class="mx-2">{{ $order->user_phone }}</span></li>
                                <li><span class="fw-medium text-dark">Địa chỉ:</span> <span class="mx-2">{{ $order->user_address }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Danh sách sản phẩm</h4>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table align-middle table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>#</th>
                                        <th>Sản phẩm</th>
                                        <th>Biến thể</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->OrderDetail as $i => $detail)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $detail->variant->product ? $detail->variant->product->name : 'Sản phẩm đã bị xóa' }}</td>
                                            <td>Mã biến thể: {{ $detail->variant_id }}</td>
                                            <td>{{ number_format($detail->variant_price, 0, ',', '.') }} đ</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ number_format($detail->total_price, 0, ',', '.') }} đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-end mt-3">
                                <div class="mb-1">Phí ship: <strong>{{ number_format(50000, 0, ',', '.') }} đ</strong></div>
                                <div class="mb-1">Giảm giá: <strong>-{{ number_format($order->discount ?? 0, 0, ',', '.') }} đ</strong></div>
                                <strong class="fs-5">Tổng tiền: {{ number_format($order->total_price, 0, ',', '.') }} đ</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">Cập nhật trạng thái</button>
                    @if($order->status_order === 'pending')
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">Huỷ đơn</button>
                    @endif
            </div>
        </div>
    </div>

    <!-- Modal cập nhật trạng thái -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('orders.updateStatus', $order->id) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">Cập nhật trạng thái đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status_order" class="form-label">Trạng thái đơn hàng</label>
                            <select name="status_order" id="status_order" class="form-select" required>
                                @foreach($statusList as $key => $label)
                                    @if($key !== 'cancelled' && $key !== 'received')
                                        <option value="{{ $key }}" {{ $order->status_order == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status_payment" class="form-label">Trạng thái thanh toán</label>
                            <input type="text" class="form-control" value="{{ $order->status_payment == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}" readonly>
                            <input type="hidden" name="status_payment" value="{{ $order->status_payment }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal huỷ đơn -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('orders.cancel', $order->id) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelOrderModalLabel">Huỷ đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="cancel_reason" class="form-label">Lý do huỷ đơn</label>
                            <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Xác nhận huỷ đơn</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 