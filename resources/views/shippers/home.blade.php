@extends('shippers.layouts.default')

@section('content')
    <div class="container">

        @if (session('success'))
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 5px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif
        {{-- Đơn có sẵn --}}
        <div class="orders-section">
            <div class="section-title">
                🆕 Đơn hàng có sẵn (chưa nhận)
            </div>
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>SĐT</th>
                            <th>Địa chỉ</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($availableOrders as $order)
                            <tr>
                                <td><span class="order-id">#{{ $order->id }}</span></td>
                                <td>{{ $order->user_email }}</td>
                                <td>{{ $order->user_phone }}</td>
                                <td>{{ $order->user_address }}</td>
                                <td><span class="price">{{ number_format($order->total_price) }}₫</span></td>
                                <td>
                                    <span class="order-status status-available">
                                        {{ ucfirst($order->status_order) }}
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('shipper.order', $order->id) }}">
                                        @csrf
                                        <button type="submit"
                                            style="padding: 5px 10px; background-color: #28a745; color: white; border: none; border-radius: 4px;">
                                            Nhận đơn
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <div>
                                        📦
                                        <p>Không có đơn hàng nào có sẵn.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Đơn đã nhận --}}
        <div class="orders-section" style="margin-top: 30px;">
            <div class="section-title">
                📦 Đơn hàng của tôi (đang giao / đã giao)
            </div>

            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>SĐT</th>
                            <th>Địa chỉ</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($myOrders as $order)
                            <tr>
                                <td><span class="order-id">#{{ $order->id }}</span></td>
                                <td>{{ $order->user_email }}</td>
                                <td>{{ $order->user_phone }}</td>
                                <td>{{ $order->user_address }}</td>
                                <td><span class="price">{{ number_format($order->total_price) }}₫</span></td>
                                <td>
                                    <span
                                        class="order-status 
                                    @if ($order->status_order == 'shipping') status-assigned
                                    @elseif($order->status_order == 'delivered') status-delivered
                                    @else status-available @endif">
                                        {{ ucfirst($order->status_order) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($order->status_order == 'shipping')
                                        <form method="POST" action="{{ route('shipper.order.complete', $order->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                Hoàn thành
                                            </button>
                                        </form>
                                    @else
                                        <span class="btn" style="background-color: #ccc;">Đã hoàn thành</span>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <div>
                                        🚛
                                        <p>Bạn chưa nhận đơn hàng nào.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
