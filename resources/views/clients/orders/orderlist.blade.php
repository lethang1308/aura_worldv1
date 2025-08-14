@extends('clients.layouts.default')

@section('content')
<!-- Hero Section -->
<section class="banner_area gradient-purple">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content text-center">
                <h2 class="text-black mb-3" style="font-size: 2.5rem; font-weight: 700;">Đơn hàng của tôi</h2>
                <p class="text-black mb-0" style="font-size: 1.1rem; opacity: 0.9;">Theo dõi và quản lý đơn hàng của bạn</p>
                <div class="d-flex justify-content-center align-items-center mt-4">
                    <a href="/" class="text-black mr-3" style="text-decoration: none;">Trang chủ</a>
                    <span class="text-black mr-3 font-weight-bold">/</span>
                    <span class="text-black font-weight-bold">Đơn hàng</span>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Main Content -->
<section class="checkout_area section_gap" style="background-color: #f8f9fa; padding: 60px 0;">
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

        <!-- Orders Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-shopping-bag mr-2"></i>
                            Danh sách đơn hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h4 class="mb-1">{{ $totalOrders }}</h4>
                                        <p class="mb-0">Tổng đơn hàng</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h4 class="mb-1">{{ number_format($totalSpent, 0, ',', '.') }}đ</h4>
                                        <p class="mb-0">Tổng chi tiêu</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h4 class="mb-1">{{ $completedOrders }}</h4>
                                        <p class="mb-0">Đơn hoàn thành</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-dark">
                                    <div class="card-body text-center">
                                        <h4 class="mb-1">{{ $pendingOrders }}</h4>
                                        <p class="mb-0">Đơn chờ xử lý</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Thống kê đơn hàng theo tháng</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="orderChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr class="text-center">
                                        <th style="width: 10%;">Mã đơn hàng</th>
                                        <th style="width: 20%;">Tổng tiền</th>
                                        <th style="width: 20%;">Trạng thái đơn</th>
                                        <th style="width: 20%;">Ngày tạo</th>
                                        <th style="width: 15%;">Mã giảm giá</th>
                                        <th style="width: 15%;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr class="text-center align-middle">
                                        <td>
                                            <strong class="text-primary">#{{ $order->id }}</strong>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-danger">
                                                {{ number_format($order->total_price, 0, ',', '.') }} đ
                                            </span>
                                        </td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $order->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($order->coupon_code)
                                            <span class="badge badge-success">{{ $order->coupon_code }}</span>
                                            @else
                                            <span class="text-muted">Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                @if ($order->status_order === 'pending')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="showCancelModal({{ $order->id }})">
                                                    <i class="fa fa-times mr-1"></i>Hủy
                                                </button>
                                                @endif
                                                <a href="{{ route('client.orders.detail', $order->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye mr-1"></i>Chi tiết
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fa fa-shopping-bag fa-3x text-muted mb-3 d-block"></i>
                                            <h5 class="text-muted">Bạn chưa có đơn hàng nào</h5>
                                            <p class="text-muted">Hãy mua sắm để có đơn hàng đầu tiên!</p>
                                            <a href="{{ route('client.products') }}" class="btn btn-primary">
                                                <i class="fa fa-shopping-cart mr-2"></i>Mua sắm ngay
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                        Hủy đơn hàng
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function showCancelModal(orderId) {
        document.getElementById('cancel_order_id').value = orderId;
        var myModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
        myModal.show();
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Chart initialization
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('orderChart').getContext('2d');

        const monthlyData = @json($monthlyStats);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [{
                    label: 'Số đơn hàng',
                    data: monthlyData.map(item => item.orders),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }, {
                    label: 'Tổng tiền (triệu VNĐ)',
                    data: monthlyData.map(item => item.total / 1000000),
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Số đơn hàng'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Tổng tiền (triệu VNĐ)'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                }
            }
        });
    });
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
</style>