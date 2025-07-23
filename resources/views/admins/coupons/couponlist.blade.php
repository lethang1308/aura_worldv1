@extends('admins.layouts.default')

@section('content')
<body>
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
                        <form method="GET" action="{{ route('coupons.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="search_code" class="form-label">Coupon Code</label>
                                <input type="text" class="form-control" id="search_code" name="search_code" value="{{ request('search_code') }}" placeholder="Search by coupon code...">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100"><i class="bx bx-search me-1"></i>Search</button>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <a href="{{ route('coupons.index') }}" class="btn btn-outline-secondary w-100"><i class="bx bx-refresh me-1"></i>Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                <h4 class="card-title flex-grow-1">All Coupon List</h4>
                                <div>
                                    @if (!isset($trash) || !$trash)
                                        <a href="{{ route('coupons.trash') }}" class="btn btn-outline-danger btn-sm">Thùng rác</a>
                                    @else
                                        <a href="{{ route('coupons.index') }}" class="btn btn-outline-primary btn-sm">Quay lại danh sách</a>
                                    @endif
                                </div>
                                <a href="{{ route('coupons.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus me-1"></i>Add Coupon
                                </a>
                            </div>
                            <div class="card-body">
                                @if ($coupons->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0 table-hover table-centered">
                                            <thead class="bg-light-subtle">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Type</th>
                                                    <th>Value</th>
                                                    <th>Min Order</th>
                                                    <th>Max Discount</th>
                                                    <th>Start</th>
                                                    <th>End</th>
                                                    <th>Used</th>
                                                    <th>Limit</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($coupons as $coupon)
                                                    <tr>
                                                        <td>{{ $coupon->id }}</td>
                                                        <td><span class="fw-bold">{{ $coupon->code }}</span></td>
                                                        <td><span class="badge bg-{{ $coupon->type == 'percent' ? 'info' : 'primary' }}">{{ ucfirst($coupon->type) }}</span></td>
                                                        <td>{{ $coupon->type == 'percent' ? $coupon->value.'%' : number_format($coupon->value) }}</td>
                                                        <td>{{ number_format($coupon->min_order_value) }}</td>
                                                        <td>{{ $coupon->max_discount ? number_format($coupon->max_discount) : '-' }}</td>
                                                        <td>{{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') : '-' }}</td>
                                                        <td>{{ $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') : '-' }}</td>
                                                        <td>{{ $coupon->used }}</td>
                                                        <td>{{ $coupon->usage_limit ?? '-' }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $coupon->status == 'active' ? 'success' : 'secondary' }}">{{ $coupon->status == 'active' ? 'Active' : 'Inactive' }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                @if (!isset($trash) || !$trash)
                                                                    <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-soft-primary btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1 mb-2" style="height: 32px; width: 32px;">
                                                                        <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                                                    </a>
                                                                    <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa coupon này không?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-soft-danger btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1" style="height: 32px; width: 32px;">
                                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <form action="{{ route('coupons.restore', $coupon->id) }}" method="POST" style="display:inline-block">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button type="submit" class="btn btn-success btn-sm">Khôi phục</button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4 pt-3 border-top">
                                        <div class="mb-3 mb-sm-0">
                                            <p class="text-muted mb-0 fs-13">
                                                @if(method_exists($coupons, 'firstItem'))
                                                    Showing {{ $coupons->firstItem() }} to {{ $coupons->lastItem() }} of {{ $coupons->total() }} results
                                                @else
                                                    Showing {{ $coupons->count() }} results
                                                @endif
                                            </p>
                                        </div>
                                        @if(method_exists($coupons, 'hasPages') && $coupons->hasPages())
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination pagination-rounded mb-0">
                                                    {{ $coupons->appends(request()->query())->links() }}
                                                </ul>
                                            </nav>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bx bx-package" style="font-size: 48px; color: #6c757d;"></i>
                                        </div>
                                        <h5 class="text-muted">
                                            @if (isset($trash) && $trash)
                                                Không có coupon nào trong thùng rác.
                                            @else
                                                No Coupons Found
                                            @endif
                                        </h5>
                                        <p class="text-muted">
                                            @if (isset($trash) && $trash)
                                                Không có coupon nào đã xóa.
                                            @else
                                                There are no coupons in the system yet.
                                            @endif
                                        </p>
                                        @if (!isset($trash) || !$trash)
                                            <a href="{{ route('coupons.create') }}" class="btn btn-primary">
                                                <i class="bx bx-plus me-1"></i>Add First Coupon
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection 