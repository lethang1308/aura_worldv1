@extends('admins.layouts.default')

@section('content')
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <!-- Form chọn ngày đã có ở đây -->
                @if(isset($from) && isset($to))
                <div class="mb-4">
                    <h5>Thống kê từ <b>{{ $from }}</b> đến <b>{{ $to }}</b></h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="card text-bg-success mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Tổng doanh thu</h6>
                                    <h4 class="card-text">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-bg-info mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Top user mua nhiều nhất</h6>
                                    <ol class="mb-0">
                                        @foreach($topUsers as $user)
                                            <li>{{ $user->user ? $user->user->name : 'N/A' }} ({{ number_format($user->total_spent, 0, ',', '.') }} đ, {{ $user->order_count }} đơn)</li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-bg-primary mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Top sản phẩm bán chạy nhất</h6>
                                    <ol class="mb-0">
                                        @foreach($topProducts as $item)
                                            <li>{{ $item->variant && $item->variant->product ? $item->variant->product->name : 'N/A' }} ({{ $item->total_sold }} sp)</li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-bg-warning mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Top sản phẩm bán ít nhất</h6>
                                    <ol class="mb-0">
                                        @foreach($bottomProducts as $item)
                                            <li>{{ $item->variant && $item->variant->product ? $item->variant->product->name : 'N/A' }} ({{ $item->total_sold }} sp)</li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!-- Kết thúc form chọn ngày -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title">All Admins List</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheckAll">
                                                </div>
                                            </th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($admins as $admin)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="check{{ $admin->id }}">
                                                    </div>
                                                </td>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->email }}</td>
                                                <td>{{ $admin->phone ?? 'Admin để trống' }}</td>
                                                <td>{{ $admin->address ?? 'Admin để trống' }}</td>
                                                <td>
                                                    @if ($admin->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $admin->created_at ? $admin->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $admin->updated_at ? $admin->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No admins found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer border-top">
                                <div class="d-flex justify-content-end">
                                    {{ $admins->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
