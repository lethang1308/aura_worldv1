@extends('admins.layouts.default')

@section('content')
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title">All Customers List</h4>
                                </div>
                                <div>
                                    @if (!isset($trash) || !$trash)
                                        <a href="{{ route('customers.trash') }}" class="btn btn-outline-danger btn-sm">Thùng
                                            rác</a>
                                    @else
                                        <a href="{{ route('customers.index') }}" class="btn btn-outline-primary btn-sm">Quay
                                            lại danh sách</a>
                                    @endif
                                </div>
                            </div>

                            {{-- Form tìm kiếm --}}
                            <div class="card-body pb-0">
                                <form method="GET" action="{{ route('customers.index') }}" class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search"
                                                    value="{{ request('search') }}"
                                                    placeholder="Tìm kiếm theo tên, email, số điện thoại hoặc địa chỉ...">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bx bx-search"></i> Tìm kiếm
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @if (request('search'))
                                                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                                                    <i class="bx bx-x"></i> Xóa bộ lọc
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                                {{-- Hiển thị kết quả tìm kiếm --}}
                                @if (request('search'))
                                    <div class="alert alert-info">
                                        <i class="bx bx-info-circle"></i>
                                        Tìm thấy {{ $customers->total() }} khách hàng cho từ khóa
                                        "<strong>{{ request('search') }}</strong>"
                                    </div>
                                @endif
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
                                            <th>Google ID</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customers as $customer)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="check{{ $customer->id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    @if (request('search'))
                                                        {!! str_ireplace(request('search'), '<mark>' . request('search') . '</mark>', $customer->name) !!}
                                                    @else
                                                        {{ $customer->name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (request('search'))
                                                        {!! str_ireplace(request('search'), '<mark>' . request('search') . '</mark>', $customer->email) !!}
                                                    @else
                                                        {{ $customer->email }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        {{ $customer->google_id}}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if (request('search') && $customer->phone)
                                                        {!! str_ireplace(
                                                            request('search'),
                                                            '<mark>' . request('search') . '</mark>',
                                                            $customer->phone ?? 'User để trống',
                                                        ) !!}
                                                    @else
                                                        {{ $customer->phone ?? 'User để trống' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (request('search') && $customer->address)
                                                        {!! str_ireplace(
                                                            request('search'),
                                                            '<mark>' . request('search') . '</mark>',
                                                            $customer->address ?? 'User để trống',
                                                        ) !!}
                                                    @else
                                                        {{ $customer->address ?? 'User để trống' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($customer->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Deactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $customer->created_at ? $customer->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $customer->updated_at ? $customer->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        @if (!isset($trash) || !$trash)
                                                            <a href="{{ route('customers.edit', $customer->id) }}"
                                                                class="btn btn-soft-primary btn-sm">
                                                                <iconify-icon icon="solar:pen-2-broken"
                                                                    class="align-middle fs-18"></iconify-icon>
                                                            </a>
                                                            <form action="{{ route('customers.destroy', $customer->id) }}"
                                                                method="POST" onsubmit="return confirm('Are you sure?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-soft-danger btn-sm">
                                                                    <iconify-icon
                                                                        icon="solar:trash-bin-minimalistic-2-broken"
                                                                        class="align-middle fs-18"></iconify-icon>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('customers.restore', $customer->id) }}"
                                                                method="POST" style="display:inline-block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-success btn-sm">Khôi
                                                                    phục</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-5">
                                                    <div class="mb-3">
                                                        <i class="bx bx-user-x"
                                                            style="font-size: 48px; color: #6c757d;"></i>
                                                    </div>
                                                    @if (request('search'))
                                                        <h5 class="text-muted">Không tìm thấy khách hàng</h5>
                                                        <p class="text-muted">Không có khách hàng nào phù hợp với từ khóa
                                                            "{{ request('search') }}"</p>
                                                        <a href="{{ route('customers.index') }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="bx bx-refresh"></i> Hiển thị tất cả
                                                        </a>
                                                    @elseif (isset($trash) && $trash)
                                                        <h5 class="text-muted">Thùng rác trống</h5>
                                                        <p class="text-muted">Không có khách hàng nào trong thùng rác.</p>
                                                    @else
                                                        <h5 class="text-muted">Chưa có khách hàng</h5>
                                                        <p class="text-muted">No customers found.</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Custom Pagination --}}
                            @if ($customers->hasPages())
                                <div class="card-footer border-top">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                                        <!-- Hiển thị thông tin số lượng -->
                                        <div class="mb-3 mb-sm-0">
                                            <p class="text-muted mb-0 fs-13">
                                                Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of
                                                {{ $customers->total() }} customers
                                            </p>
                                        </div>

                                        <!-- Custom Pagination -->
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination pagination-rounded mb-0">
                                                {{-- Previous Page Link --}}
                                                @if ($customers->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link" aria-hidden="true">
                                                            <i class="bx bx-chevron-left"></i>
                                                        </span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $customers->previousPageUrl() }}"
                                                            rel="prev" aria-label="Previous">
                                                            <i class="bx bx-chevron-left"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- Pagination Elements --}}
                                                @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                                                    @if ($page == $customers->currentPage())
                                                        <li class="page-item active">
                                                            <span class="page-link">{{ $page }}</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ $url }}">{{ $page }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                {{-- Next Page Link --}}
                                                @if ($customers->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $customers->nextPageUrl() }}"
                                                            rel="next" aria-label="Next">
                                                            <i class="bx bx-chevron-right"></i>
                                                        </a>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled">
                                                        <span class="page-link" aria-hidden="true">
                                                            <i class="bx bx-chevron-right"></i>
                                                        </span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
