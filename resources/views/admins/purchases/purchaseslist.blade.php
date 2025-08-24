@extends('admins.layouts.default')

@section('content')
<div class="wrapper">
    <div class="page-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">Danh sách đơn hàng đã thanh toán</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover table-centered">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th>#</th>
                                    <th>Mã đơn</th>
                                    <th>Phương thức</th>
                                    <th>Số tiền</th>
                                    <th>Ngày thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->payment->payment_method ?? 'N/A' }}</td>
                                        <td>{{ number_format($order->payment->amount, 0, ',', '.') }}₫</td>
                                        <td>{{ $order->payment->payment_date ?? 'N/A' }}</td>
                                        <td>
                                            @if ($order->payment->transaction->transaction_status ?? false)
                                                <span class="badge bg-success">{{ $order->payment->transaction->transaction_status }}</span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('purchases.show', $order->id) }}"
                                               class="btn btn-soft-info btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1"
                                               style="height: 32px; width: 32px;" title="Xem chi tiết">
                                                <iconify-icon icon="solar:eye-bold-duotone" class="align-middle fs-18"></iconify-icon>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có đơn hàng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
