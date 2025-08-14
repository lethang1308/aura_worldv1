@extends('admins.layouts.default')

@section('content')
<div class="wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3 align-items-end mb-0">
                        <div class="col-auto">
                            <label for="from_date" class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" id="from_date" name="from_date" value="{{ request('from_date', $from ?? date('Y-m-d')) }}">
                        </div>
                        <div class="col-auto">
                            <label for="to_date" class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" id="to_date" name="to_date" value="{{ request('to_date', $to ?? date('Y-m-d')) }}">
                        </div>
                        <div class="col-auto">
                            <label for="quick_range" class="form-label">Chọn nhanh</label>
                            <select class="form-select" id="quick_range" name="quick_range" onchange="handleQuickRange(this.value)">
                                <option value="">-- Tuỳ chọn --</option>
                                <option value="today">Hôm nay</option>
                                <option value="yesterday">Hôm qua</option>
                                <option value="this_week">Tuần này</option>
                                <option value="last_week">Tuần trước</option>
                                <option value="this_month">Tháng này</option>
                                <option value="last_month">Tháng trước</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Xem thống kê</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                function handleQuickRange(val) {
                    const today = new Date();
                    let from = '';
                    let to = '';
                    if (val === 'today') {
                        from = to = today.toISOString().slice(0, 10);
                    } else if (val === 'yesterday') {
                        const yest = new Date(today);
                        yest.setDate(today.getDate() - 1);
                        from = to = yest.toISOString().slice(0, 10);
                    } else if (val === 'this_week') {
                        const first = new Date(today);
                        first.setDate(today.getDate() - today.getDay() + 1);
                        from = first.toISOString().slice(0, 10);
                        to = today.toISOString().slice(0, 10);
                    } else if (val === 'last_week') {
                        const first = new Date(today);
                        first.setDate(today.getDate() - today.getDay() - 6);
                        const last = new Date(today);
                        last.setDate(today.getDate() - today.getDay());
                        from = first.toISOString().slice(0, 10);
                        to = last.toISOString().slice(0, 10);
                    } else if (val === 'this_month') {
                        const first = new Date(today.getFullYear(), today.getMonth(), 1);
                        from = first.toISOString().slice(0, 10);
                        to = today.toISOString().slice(0, 10);
                    } else if (val === 'last_month') {
                        const first = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        const last = new Date(today.getFullYear(), today.getMonth(), 0);
                        from = first.toISOString().slice(0, 10);
                        to = last.toISOString().slice(0, 10);
                    }
                    if (from && to) {
                        document.getElementById('from_date').value = from;
                        document.getElementById('to_date').value = to;
                    }
                }
            </script>

            @if(isset($from) && isset($to))
            <div class="mb-4">
                <h5>Thống kê từ <b>{{ $from }}</b> đến <b>{{ $to }}</b></h5>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <div class="card text-bg-success mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Tổng doanh thu</h6>
                                <h4 class="card-text">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-primary mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Tổng đơn hàng</h6>
                                <h4 class="card-text">{{ $totalOrders }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-info mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Đơn hoàn tất</h6>
                                <h4 class="card-text">{{ $completedOrders }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-warning mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Đơn đang chờ</h6>
                                <h4 class="card-text">{{ $pendingOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <div class="card text-bg-secondary mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Đơn đã nhận</h6>
                                <h4 class="card-text">{{ $receivedOrders }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-danger mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Đơn huỷ</h6>
                                <h4 class="card-text">{{ $cancelledOrders }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Khách hàng mới</h6>
                                <h4 class="card-text">{{ $newCustomers }}</h4>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Giá trị đơn TB</h6>
                                <h4 class="card-text">{{ number_format($averageOrderValue, 0, ',', '.') }} đ</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Doanh thu theo ngày</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueChart" height="120"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Đơn theo trạng thái</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="statusChart" height="260"></canvas>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Theo phương thức thanh toán</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="paymentChart" height="260"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-info-subtle">
                                <h6 class="mb-0">Top user mua nhiều nhất</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th>#</th>
                                                <th>Tên user</th>
                                                <th>Tổng chi tiêu</th>
                                                <th>Số đơn</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topUsers as $i => $user)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td>{{ $user->user ? $user->user->name : 'N/A' }}</td>
                                                <td>{{ number_format($user->total_spent, 0, ',', '.') }} đ</td>
                                                <td>{{ $user->order_count }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-primary-subtle">
                                <h6 class="mb-0">Top sản phẩm bán chạy nhất</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th>#</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Số lượng bán</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topProducts as $i => $item)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td>{{ $item->variant && $item->variant->product ? $item->variant->product->name : 'N/A' }}</td>
                                                <td>{{ $item->total_sold }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-success-subtle">
                                <h6 class="mb-0">Top danh mục theo doanh thu</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th>#</th>
                                                <th>Danh mục</th>
                                                <th>Số lượng bán</th>
                                                <th>Doanh thu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topCategories as $i => $cat)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td>{{ $cat->category_name }}</td>
                                                <td>{{ $cat->total_quantity }}</td>
                                                <td>{{ number_format($cat->revenue, 0, ',', '.') }} đ</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-warning-subtle">
                                <h6 class="mb-0">Top sản phẩm bán ít nhất</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th>#</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Số lượng bán</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bottomProducts as $i => $item)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td>{{ $item->variant && $item->variant->product ? $item->variant->product->name : 'N/A' }}</td>
                                                <td>{{ $item->total_sold }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($revenueLabels ?? []),
                datasets: [{
                    label: 'Doanh thu',
                    data: @json($revenueSeries ?? []),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.15)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = @json($ordersByStatus ?? []);
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#6366f1']
                }]
            }
        });
    }

    const payCtx = document.getElementById('paymentChart');
    if (payCtx) {
        const payData = @json($ordersByPayment ?? []);
        new Chart(payCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(payData),
                datasets: [{
                    data: Object.values(payData),
                    backgroundColor: ['#0ea5e9', '#22c55e']
                }]
            }
        });
    }
</script>
@endpush
@endsection