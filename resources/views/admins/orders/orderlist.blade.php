@extends('admins.layouts.default')

@section('content')
<div class="wrapper">
    <div class="page-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('orders.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Mã đơn hàng</label>
                            <input type="text" name="order_id" class="form-control" placeholder="Mã đơn hàng" value="{{ request('order_id') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tên tài khoản</label>
                            <input type="text" name="user_name" class="form-control" placeholder="Tên tài khoản" value="{{ request('user_name') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Trạng thái đơn hàng</label>
                            <select name="status_order" class="form-select">
                                <option value="">Tất cả trạng thái</option>
                                @foreach($statusList as $key => $label)
                                    <option value="{{ $key }}" {{ request('status_order') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search me-1"></i>Tìm kiếm</button>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary"><i class="bx bx-refresh me-1"></i>Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Danh sách đơn hàng</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover table-centered">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Tài khoản</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Địa chỉ</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái đơn</th>
                                    <th>Thanh toán</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                                        <td>{{ $order->user_email }}</td>
                                        <td>{{ $order->user_phone }}</td>
                                        <td>{{ $order->user_address }}</td>
                                        <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                        <td>
                                            <span class="badge bg-info">{{ $statusList[$order->status_order] ?? $order->status_order }}</span>
                                        </td>
                                        <td>
                                            @if($order->status_payment === 'paid')
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->created_at)
                                                {{ $order->created_at->format('d/m/Y H:i') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-soft-info btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1" style="height: 32px; width: 32px;" title="Chi tiết">
                                                <iconify-icon icon="solar:eye-bold-duotone" class="align-middle fs-18"></iconify-icon>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="10" class="text-center">Không có đơn hàng nào</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 