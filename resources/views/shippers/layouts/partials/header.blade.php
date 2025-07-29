<div class="container">
    <div class="header"
        style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); color: #333; position: relative;">
        <div style="position: absolute; top: 20px; right: 30px;">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary" style="font-size: 0.9rem; padding: 8px 16px;">
                    🚪 Đăng xuất
                </button>
            </form>
        </div>
        <h1>🚚 Shipper Dashboard</h1>
        <p>Quản lý đơn hàng giao dịch của bạn</p>
    </div>

    {{-- Thống kê --}}
    <div class="stats" style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
        <div class="stat-card"
            style="flex: 1; min-width: 200px; background: #f1f1f1; padding: 20px; border-radius: 10px; text-align: center;">
            <div class="stat-number" style="font-size: 24px; font-weight: bold;">{{ $stats['available'] ?? 0 }}</div>
            <div class="stat-label">Đơn có sẵn</div>
        </div>
        <div class="stat-card"
            style="flex: 1; min-width: 200px; background: #f1f1f1; padding: 20px; border-radius: 10px; text-align: center;">
            <div class="stat-number" style="font-size: 24px; font-weight: bold;">{{ $stats['assigned'] ?? 0 }}</div>
            <div class="stat-label">Đơn đã nhận</div>
        </div>
        <div class="stat-card"
            style="flex: 1; min-width: 200px; background: #f1f1f1; padding: 20px; border-radius: 10px; text-align: center;">
            <div class="stat-number" style="font-size: 24px; font-weight: bold;">{{ $stats['delivered'] ?? 0 }}</div>
            <div class="stat-label">Đã giao hàng</div>
        </div>
    </div>
