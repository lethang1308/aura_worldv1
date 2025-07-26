@extends('admins.layouts.default')

@section('content')
<div class="wrapper">
    <div class="page-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Chi tiết thanh toán đơn hàng #{{ $order->id }}</h4>
                </div>
                <div class="card-body">

                    <h5 class="mb-3">Thông tin thanh toán</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="25%">Phương thức</th>
                                    <td>{{ $order->payment->payment_method ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Số tiền</th>
                                    <td>{{ number_format($order->payment->amount, 0, ',', '.') }}₫</td>
                                </tr>
                                <tr>
                                    <th>Ngày thanh toán</th>
                                    <td>{{ $order->payment->payment_date ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mb-3">Chi tiết giao dịch</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="25%">Cổng thanh toán</th>
                                    <td>{{ $order->payment->transaction->gateway ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if($order->payment->transaction->transaction_status === 'success')
                                            <span class="badge bg-success">Thành công</span>
                                        @elseif($order->payment->transaction->transaction_status === 'failed')
                                            <span class="badge bg-danger">Thất bại</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $order->payment->transaction->transaction_status ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mã giao dịch</th>
                                    <td>{{ $order->payment->transaction->id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Loại tiền</th>
                                    <td>{{ $order->payment->transaction->currency ?? 'VND' }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày giao dịch</th>
                                    <td>{{ $order->payment->transaction->transaction_date ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary mt-3">
                        <i class="bx bx-arrow-back"></i> Quay lại danh sách
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
