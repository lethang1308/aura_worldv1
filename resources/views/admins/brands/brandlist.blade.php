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

                <!-- Form tìm kiếm -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('brands.index') }}" class="row g-3">
                            <div class="col-md-6">
                                <label for="search_name" class="form-label">Brand Name</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="search_name" 
                                       name="search_name" 
                                       value="{{ request('search_name') }}" 
                                       placeholder="Search by brand name...">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label d-block">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-search me-1"></i>Search
                                    </button>
                                    <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-refresh me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Hiển thị kết quả tìm kiếm nếu có -->
                        @if(request('search_name'))
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="text-muted">Search filters:</span>
                                    <span class="badge bg-primary-subtle text-primary">
                                        Name: "{{ request('search_name') }}"
                                        <a href="{{ route('brands.index') }}" 
                                           class="text-decoration-none ms-1">×</a>
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                <h4 class="card-title flex-grow-1">All Brand List</h4>
                                <a href="{{ route('brands.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus me-1"></i>Add Brand
                                </a>
                            </div>
                            <div class="card-body">
                                @if ($brands->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0 table-hover table-centered">
                                            <thead class="bg-light-subtle">
                                                <tr>
                                                    <th style="width: 20px;"></th>
                                                    <th>Logo</th>
                                                    <th>Brand Name</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Created Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($brands as $brand)
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            @if($brand->logo)
                                                                <img src="{{ asset($brand->logo) }}" alt="Logo" class="rounded border" style="width:60px;height:40px;object-fit:cover;">
                                                            @else
                                                                <span class="badge bg-secondary-subtle text-secondary">No Logo</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="fw-medium fs-15">{{ $brand->name }}</span>
                                                            <p class="text-muted mb-0 mt-1 fs-13"><span>ID: </span>#{{ $brand->id }}</p>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">{{ $brand->description ? Str::limit($brand->description, 50) : 'No description' }}</span>
                                                        </td>
                                                        <td>
                                                            @if($brand->status == 'active')
                                                                <span class="badge bg-success-subtle text-success">Active</span>
                                                            @else
                                                                <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="text-muted fs-13">{{ $brand->created_at }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-soft-primary btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1 mb-2" style="height: 32px; width: 32px;">
                                                                    <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                                                </a>
                                                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá thương hiệu này không?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-soft-danger btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1" style="height: 32px; width: 32px;">
                                                                        <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4 pt-3 border-top">
                                        <!-- Hiển thị thông tin số lượng -->
                                        <div class="mb-3 mb-sm-0">
                                            <p class="text-muted mb-0 fs-13">
                                                Showing {{ $brands->firstItem() }} to {{ $brands->lastItem() }} of
                                                {{ $brands->total() }} results
                                            </p>
                                        </div>

                                        <!-- Custom Pagination -->
                                        @if ($brands->hasPages())
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination pagination-rounded mb-0">
                                                    {{-- Previous Page Link --}}
                                                    @if ($brands->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link" aria-hidden="true">
                                                                <i class="bx bx-chevron-left"></i>
                                                            </span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ $brands->appends(request()->query())->previousPageUrl() }}"
                                                                rel="prev" aria-label="Previous">
                                                                <i class="bx bx-chevron-left"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    {{-- Pagination Elements --}}
                                                    @foreach ($brands->getUrlRange(1, $brands->lastPage()) as $page => $url)
                                                        @if ($page == $brands->currentPage())
                                                            <li class="page-item active">
                                                                <span class="page-link">{{ $page }}</span>
                                                            </li>
                                                        @else
                                                            <li class="page-item">
                                                                <a class="page-link"
                                                                    href="{{ $brands->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach

                                                    {{-- Next Page Link --}}
                                                    @if ($brands->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ $brands->appends(request()->query())->nextPageUrl() }}" rel="next"
                                                                aria-label="Next">
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
                                        @endif
                                    </div>

                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bx bx-package" style="font-size: 48px; color: #6c757d;"></i>
                                        </div>
                                        <h5 class="text-muted">No Brands Found</h5>
                                        <p class="text-muted">There are no brands in the system yet.</p>
                                        <a href="{{ route('brands.create') }}" class="btn btn-primary">
                                            <i class="bx bx-plus me-1"></i>Add First Brand
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('admin/assets/js/vendor.js') }}"></script>
        <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    </body>
@endsection