<style>
    .status-pill {
        display: inline-block;
        padding: 4px 10px;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 20px;
        border: 1px solid transparent;
    }

    /* Trạng thái đơn */
    .status-pending {
        background-color: #fff8e1;
        color: #ff9800;
        border-color: #ff9800;
    }

    .status-confirmed {
        background-color: #e3f2fd;
        color: #2196f3;
        border-color: #2196f3;
    }

    .status-shipping {
        background-color: #e0f7fa;
        color: #00acc1;
        border-color: #00acc1;
    }

    .status-shipped {
        background-color: #f1f8e9;
        color: #558b2f;
        border-color: #558b2f;
    }

    .status-received {
        background-color: #f1f8e9;
        color: #4caf50;
        border-color: #4caf50;
    }

    .status-completed {
        background-color: #e8f5e9;
        color: #388e3c;
        border-color: #388e3c;
    }

    .status-cancelled {
        background-color: #ffebee;
        color: #d32f2f;
        border-color: #d32f2f;
    }

    /* Trạng thái thanh toán */
    .pay-paid {
        background-color: #e8f5e9;
        color: #388e3c;
        border-color: #388e3c;
    }

    .pay-pending {
        background-color: #fff8e1;
        color: #ff9800;
        border-color: #ff9800;
    }

    .pay-failed {
        background-color: #ffebee;
        color: #d32f2f;
        border-color: #d32f2f;
    }

    .pay-unpaid {
        background-color: #fbe9e7;
        color: #e64a19;
        border-color: #e64a19;
    }
</style>

@extends('clients.layouts.default')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4" style="font-weight:700; font-size:2rem;">Đơn hàng của tôi</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm rounded" style="background:#fff;">
                <thead style="background:#4cd964; color:#fff; font-weight:700; text-align:center;">
                    <tr class="text-center align-middle">
                        <th style="min-width:150px;">Mã đơn hàng</th>
                        <th style="min-width:120px;">Tổng tiền</th>
                        <th style="min-width:150px;">Trạng thái đơn</th>
                        <th style="min-width:180px;">Trạng thái thanh toán</th>
                        <th style="min-width:150px;">Ngày tạo</th>
                        <th style="min-width:150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="text-center align-middle" data-id="{{ $order->id }}">
                            <td>
                                <a href="{{ route('client.orders.detail', $order->id) }}"
                                    style="text-decoration:none; font-weight:600; color:#007bff;">
                                    #{{ $order->id }}
                                </a>
                            </td>
                            <td style="font-weight:600;">{{ number_format($order->total_price, 0, ',', '.') }} vnd</td>
                            <td class="status-order">
                                @if ($order->status_order === 'pending')
                                    <span class="status-pill status-pending">Chưa xác nhận</span>
                                @elseif($order->status_order === 'confirmed')
                                    <span class="status-pill status-confirmed">Đã xác nhận</span>
                                @elseif($order->status_order === 'shipping')
                                    <span class="status-pill status-shipping">Đang giao hàng</span>
                                @elseif($order->status_order === 'shipped')
                                    <span class="status-pill status-shipped">Đã giao hàng</span>
                                @elseif($order->status_order === 'received')
                                    <span class="status-pill status-received">Đã nhận hàng</span>
                                @elseif($order->status_order === 'completed')
                                    <span class="status-pill status-completed">Hoàn thành</span>
                                @elseif($order->status_order === 'cancelled')
                                    <span class="status-pill status-cancelled">Đã huỷ</span>
                                @else
                                    <span class="status-pill">{{ strtoupper($order->status_order) }}</span>
                                @endif
                            </td>
                            <td class="status-payment">
                                @if ($order->status_payment === 'paid')
                                    <span class="status-pill pay-paid">Đã thanh toán</span>
                                @elseif($order->status_payment === 'pending')
                                    <span class="status-pill pay-pending">Chờ thanh toán</span>
                                @elseif($order->status_payment === 'failed')
                                    <span class="status-pill pay-failed">Thanh toán thất bại</span>
                                @elseif($order->status_payment === 'unpaid')
                                    <span class="status-pill pay-unpaid">Chưa thanh toán</span>
                                @else
                                    <span class="status-pill">{{ strtoupper($order->status_payment ?? '-') }}</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="action-cell">
                                @if ($order->status_order === 'shipped')
                                    <button type="button" class="btn btn-success btn-sm btn-complete"
                                        data-id="{{ $order->id }}">
                                        Hoàn thành
                                    </button>
                                @elseif ($order->status_order === 'completed')
                                    <button class="btn btn-secondary btn-sm" disabled>Đã hoàn thành</button>
                                @else
                                    <button class="btn btn-light btn-sm" disabled>Không khả dụng</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Bạn chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-complete').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    let orderId = this.getAttribute('data-id');
                    let row = this.closest('tr');

                    fetch(`/clients/orders/${orderId}/complete`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                row.querySelector('.action-cell').innerHTML =
                                    '<button class="btn btn-secondary btn-sm" disabled>Đã hoàn thành</button>';
                                row.querySelector('.status-order').innerHTML =
                                    '<span class="status-pill status-completed">Hoàn thành</span>';
                                row.querySelector('.status-payment').innerHTML =
                                    '<span class="status-pill pay-paid">Đã thanh toán</span>';
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert("Có lỗi xảy ra khi hoàn thành đơn hàng!");
                        });
                });
            });
        });
    </script>
@endsection
