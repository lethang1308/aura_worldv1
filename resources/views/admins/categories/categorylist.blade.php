@extends('admins.layouts.default')

@section('content')
    <!-- START Wrapper -->
    <div class="wrapper">

        <!-- ==================================================== -->
        <!-- Start right Content here -->
        <!-- ==================================================== -->
        <div class="page-content">

            <!-- Start Container Fluid -->
            <div class="container-xxl">
                {{-- Hiển thị thông báo thành công --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Hiển thị thông báo lỗi --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Hiển thị lỗi từ validator --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Form tìm kiếm -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('categories.index') }}" class="row g-3">
                            <div class="col-md-6">
                                <label for="search_name" class="form-label">Tên danh mục</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="search_name" 
                                       name="search_name" 
                                       value="{{ request('search_name') }}" 
                                       placeholder="Tìm theo tên danh mục...">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label d-block">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-search me-1"></i>Tìm kiếm
                                    </button>
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-refresh me-1"></i>Đặt lại
                                    </a>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Hiển thị kết quả tìm kiếm nếu có -->
                        @if(request('search_name'))
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="text-muted">Bộ lọc tìm kiếm:</span>
                                    <span class="badge bg-primary-subtle text-primary">Tên: "{{ request('search_name') }}"
                                        <a href="{{ route('categories.index') }}" 
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
                                <h4 class="card-title flex-grow-1">Danh sách danh mục</h4>
                                <div>
                                    @if (!isset($trash) || !$trash)
                                        <a href="{{ route('categories.trash') }}" class="btn btn-outline-danger btn-sm">Thùng rác</a>
                                    @else
                                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-sm">Quay lại danh sách</a>
                                    @endif
                                </div>
                                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Thêm danh mục</a>

                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Tháng này
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="#!" class="dropdown-item">Tải xuống</a>
                                        <!-- item-->
                                        <a href="#!" class="dropdown-item">Xuất file</a>
                                        <!-- item-->
                                        <a href="#!" class="dropdown-item">Nhập file</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($categories->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0 table-hover table-centered">
                                            <thead class="bg-light-subtle">
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="customCheck1">
                                                            <label class="form-check-label" for="customCheck1"></label>
                                                        </div>
                                                    </th>
                                                    <th>Danh mục</th>
                                                    <th>ID</th>
                                                    <th>Danh mục cha</th>
                                                    <th>Mô tả</th>
                                                    <th>Trạng thái</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Ngày cập nhật</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($categories as $category)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="customCheck2">
                                                                <label class="form-check-label" for="customCheck2"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <p class="text-dark fw-medium fs-15 mb-0">
                                                                    {{ $category->category_name }}</p>
                                                            </div>

                                                        </td>
                                                        <td>{{ $category->id }}</td>
                                                        <td>
                                                            @if ($category->parent_category_id === null)
                                                                <span class="text-primary fw-bold">Danh mục cha</span>
                                                            @elseif ($category->parentCategory)
                                                                <span class="text-success fw-semibold">
                                                                    {{ $category->parentCategory->category_name }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">Chưa xác định</span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <p class="text-dark fw-medium fs-15 mb-0">
                                                                {{ isset($category->description) && !empty($category->description) ? $category->description : 'Chưa có mô tả' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            @if ($category->status === '1')
                                                                <span class="badge bg-success">Đang hoạt động</span>
                                                            @elseif($category->status === '0')
                                                                <span class="badge bg-danger">Ngừng hoạt động</span>
                                                            @else
                                                                <span class="badge bg-secondary">Không xác định</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $category->created_at ? $category->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                        </td>
                                                        <td>
                                                            {{ $category->updated_at ? $category->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                                        </td>

                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                @if (!isset($trash) || !$trash)
                                                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-soft-primary btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1 mb-2" style="height: 32px; width: 32px;">
                                                                        <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                                                    </a>
                                                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá danh mục này không?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-soft-danger btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1" style="height: 32px; width: 32px;">
                                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <form action="{{ route('categories.restore', $category->id) }}" method="POST" style="display:inline-block">
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
                                    <!-- end table-responsive -->
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bx bx-category" style="font-size: 48px; color: #6c757d;"></i>
                                        </div>
                                        <h5 class="text-muted">Không tìm thấy danh mục nào</h5>
                                        <p class="text-muted">
                                            @if(request('search_name'))
                                                Không có danh mục nào phù hợp với tiêu chí tìm kiếm.
                                            @else
                                                Chưa có danh mục nào trong hệ thống.
                                            @endif
                                        </p>
                                        @if(!request('search_name'))
                                            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                                <i class="bx bx-plus me-1"></i>Thêm danh mục đầu tiên
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer border-top">
                                @if ($categories->count() > 0)
                                    <!-- Pagination -->
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                                        <!-- Hiển thị thông tin số lượng -->
                                        <div class="mb-3 mb-sm-0">
                                            <p class="text-muted mb-0 fs-13">
                                                @if(method_exists($categories, 'firstItem'))
                                                    Hiển thị {{ $categories->firstItem() }} đến {{ $categories->lastItem() }} trong tổng số {{ $categories->total() }} kết quả
                                                @else
                                                    Hiển thị {{ $categories->count() }} kết quả
                                                @endif
                                            </p>
                                        </div>

                                        <!-- Custom Pagination -->
                                        @if(method_exists($categories, 'hasPages') && $categories->hasPages())
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination pagination-rounded mb-0">
                                                    {{-- Previous Page Link --}}
                                                    @if(method_exists($categories, 'onFirstPage') && $categories->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link" aria-hidden="true">
                                                                <i class="bx bx-chevron-left"></i>
                                                            </span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ $categories->appends(request()->query())->previousPageUrl() }}"
                                                                rel="prev" aria-label="Trước">
                                                                <i class="bx bx-chevron-left"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    {{-- Pagination Elements --}}
                                                    @if(method_exists($categories, 'getUrlRange'))
                                                        @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                                            @if ($page == $categories->currentPage())
                                                                <li class="page-item active">
                                                                    <span class="page-link">{{ $page }}</span>
                                                                </li>
                                                            @else
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                        href="{{ $categories->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    {{-- Next Page Link --}}
                                                    @if(method_exists($categories, 'hasMorePages') && $categories->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ $categories->appends(request()->query())->nextPageUrl() }}" rel="next"
                                                                aria-label="Sau">
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Container Fluid -->
        </div>
        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->


    </div>
@endsection