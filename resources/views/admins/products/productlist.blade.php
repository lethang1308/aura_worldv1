@extends('admins.layouts.default')

@section('content')
    <body>
        <!-- START Wrapper -->
        <div class="wrapper">
            <!-- Right Sidebar (Theme Settings) -->
            <div>
                <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="theme-settings-offcanvas">
                    <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
                        <h5 class="text-white m-0">Cài đặt giao diện</h5>
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"
                            aria-label="Đóng"></button>
                    </div>

                    <div class="offcanvas-body p-0">
                        <div data-simplebar class="h-100">
                            <div class="p-3 settings-bar">
                                <div>
                                    <h5 class="mb-3 font-16 fw-semibold">Màu sắc giao diện</h5>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="data-bs-theme"
                                            id="layout-color-light" value="light">
                                        <label class="form-check-label" for="layout-color-light">Sáng</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="data-bs-theme"
                                            id="layout-color-dark" value="dark">
                                        <label class="form-check-label" for="layout-color-dark">Tối</label>
                                    </div>
                                </div>
                                <!-- Các phần theme settings khác giữ nguyên -->
                            </div>
                        </div>
                    </div>
                    <div class="offcanvas-footer border-top p-3 text-center">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-danger w-100" id="reset-layout">Đặt lại</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-content">
                <!-- Start Container Fluid -->
                <div class="container-fluid">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                        </div>
                    @endif

                    <!-- Form tìm kiếm - Thêm vào sau phần Success/Error Message và trước <div class="row"> -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                                <div class="col-md-4">
                                    <label for="search_name" class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="search_name" name="search_name"
                                        value="{{ request('search_name') }}" placeholder="Tìm kiếm theo tên sản phẩm...">
                                </div>

                                <div class="col-md-3">
                                    <label for="search_brand" class="form-label">Thương hiệu</label>
                                    <select class="form-select" id="search_brand" name="search_brand">
                                        <option value="">Tất cả thương hiệu</option>
                                        @if (isset($brands))
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->name }}"
                                                    {{ request('search_brand') == $brand->name ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="search_category" class="form-label">Danh mục</label>
                                    <select class="form-select" id="search_category" name="search_category">
                                        <option value="">Tất cả danh mục</option>
                                        @if (isset($categories))
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->category_name }}"
                                                    {{ request('search_category') == $category->category_name ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label d-block">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-search me-1"></i>Tìm kiếm
                                        </button>
                                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                            <i class="bx bx-refresh me-1"></i>Đặt lại
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <!-- Hiển thị kết quả tìm kiếm nếu có -->
                            @if (request()->hasAny(['search_name', 'search_brand', 'search_category']))
                                <div class="mt-3 pt-3 border-top">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span class="text-muted">Bộ lọc tìm kiếm:</span>

                                        @if (request('search_name'))
                                            <span class="badge bg-primary-subtle text-primary">
                                                Tên: "{{ request('search_name') }}"
                                                <a href="{{ route('products.index', request()->except('search_name')) }}"
                                                    class="text-decoration-none ms-1">×</a>
                                            </span>
                                        @endif

                                        @if (request('search_brand'))
                                            <span class="badge bg-info-subtle text-info">
                                                Thương hiệu: "{{ request('search_brand') }}"
                                                <a href="{{ route('products.index', request()->except('search_brand')) }}"
                                                    class="text-decoration-none ms-1">×</a>
                                            </span>
                                        @endif

                                        @if (request('search_category'))
                                            <span class="badge bg-success-subtle text-success">
                                                Danh mục: "{{ request('search_category') }}"
                                                <a href="{{ route('products.index', request()->except('search_category')) }}"
                                                    class="text-decoration-none ms-1">×</a>
                                            </span>
                                        @endif

                                        <a href="{{ route('products.index') }}"
                                            class="btn btn-sm btn-outline-secondary">Xóa tất cả</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                    <h4 class="card-title flex-grow-1">Danh sách sản phẩm</h4>
                                    <div>
                                        @if (!isset($trash) || !$trash)
                                            <a href="{{ route('products.trash') }}"
                                                class="btn btn-outline-danger btn-sm">Thùng rác</a>
                                        @else
                                            <a href="{{ route('products.index') }}"
                                                class="btn btn-outline-primary btn-sm">Quay lại danh sách</a>
                                        @endif
                                    </div>
                                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
                                        <i class="bx bx-plus me-1"></i>Thêm sản phẩm
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#!" class="dropdown-item">
                                                <i class="bx bx-download me-2"></i>Tải xuống
                                            </a>
                                            <a href="#!" class="dropdown-item">
                                                <i class="bx bx-export me-2"></i>Xuất file
                                            </a>
                                            <a href="#!" class="dropdown-item">
                                                <i class="bx bx-import me-2"></i>Nhập file
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if ($products->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0 table-hover table-centered">
                                                <thead class="bg-light-subtle">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check ms-1">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="customCheckAll">
                                                                <label class="form-check-label"
                                                                    for="customCheckAll"></label>
                                                            </div>
                                                        </th>
                                                        <th>Tên sản phẩm</th>
                                                        <th>Giá</th>
                                                        <th>Danh mục</th>
                                                        <th>Thương hiệu</th>
                                                        <th>Mô tả</th>
                                                        <th>Ngày tạo</th>
                                                        <th>Ngày cập nhật</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($products as $product)
                                                        <tr>
                                                            <td>
                                                                <div class="form-check ms-1">
                                                                    <input type="checkbox"
                                                                        class="form-check-input product-checkbox"
                                                                        id="customCheck{{ $product->id }}"
                                                                        value="{{ $product->id }}">
                                                                    <label class="form-check-label"
                                                                        for="customCheck{{ $product->id }}"> </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div
                                                                        class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                                        <img src="{{ $product->featuredImage ? asset('storage/' . $product->featuredImage->path) : asset('admin/assets/images/product/placeholder.png') }}"
                                                                            alt="{{ $product->name }}" class="avatar-md">
                                                                    </div>
                                                                    <div>
                                                                        <a href="{{ route('products.show', $product->id) }}"
                                                                            class="text-dark fw-medium fs-15">
                                                                            {{ Str::limit($product->name, 30) }}
                                                                        </a>
                                                                        <p class="text-muted mb-0 mt-1 fs-13">
                                                                            <span>Mã: </span>#{{ $product->id }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="fw-medium text-success">{{ number_format($product->base_price, 0, ',', '.') }}₫</span>
                                                            </td>
                                                            <td>
                                                                @if ($product->category)
                                                                    <span
                                                                        class="badge bg-success-subtle text-success">{{ $product->category->category_name }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-secondary-subtle text-secondary">Không
                                                                        có danh mục</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($product->brand)
                                                                    <span
                                                                        class="badge bg-info-subtle text-info">{{ $product->brand->name }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-secondary-subtle text-secondary">Không
                                                                        có thương hiệu</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="text-muted">
                                                                    {{ $product->description ? Str::limit($product->description, 50) : 'Chưa có mô tả' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fs-13">
                                                                    {{ $product->created_at->format('d/m/Y H:i') }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fs-13">
                                                                    {{ $product->updated_at->format('d/m/Y H:i') }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex gap-2 align-items-center">
                                                                    @if (isset($trash) && $trash)
                                                                        <form
                                                                            action="{{ route('products.restore', $product->id) }}"
                                                                            method="POST" style="display:inline-block">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button type="submit"
                                                                                class="btn btn-success btn-sm">Khôi
                                                                                phục</button>
                                                                        </form>
                                                                        <form
                                                                            action="{{ route('products.forceDelete', $product->id) }}"
                                                                            method="POST"
                                                                            style="display:inline-block; margin-left: 4px;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm"
                                                                                onclick="return confirm('Bạn có chắc muốn xoá vĩnh viễn sản phẩm này?');">Xoá
                                                                                vĩnh viễn</button>
                                                                        </form>
                                                                    @else
                                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                                            class="btn btn-soft-primary btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1"
                                                                            style="height: 32px; width: 32px;"
                                                                            title="Chỉnh sửa">
                                                                            <iconify-icon icon="solar:pen-2-broken"
                                                                                class="align-middle fs-18"></iconify-icon>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('products.destroy', $product->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Bạn có chắc muốn xoá sản phẩm này không?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-soft-danger btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1"
                                                                                style="height: 32px; width: 32px;"
                                                                                title="Xóa">
                                                                                <iconify-icon
                                                                                    icon="solar:trash-bin-minimalistic-2-broken"
                                                                                    class="align-middle fs-18"></iconify-icon>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @if ($products->isEmpty())
                                                        <tr>
                                                            <td colspan="9" class="text-center">
                                                                @if (isset($trash) && $trash)
                                                                    Không có sản phẩm nào trong thùng rác.
                                                                @else
                                                                    Không tìm thấy sản phẩm nào
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div
                                            class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4 pt-3 border-top">
                                            <!-- Hiển thị thông tin số lượng -->
                                            <div class="mb-3 mb-sm-0">
                                                <p class="text-muted mb-0 fs-13">
                                                    @if (method_exists($products, 'firstItem'))
                                                        Hiển thị {{ $products->firstItem() }} đến {{ $products->lastItem() }} trong tổng số {{ $products->total() }} kết quả
                                                    @else
                                                        Hiển thị {{ $products->count() }} kết quả
                                                    @endif
                                                </p>
                                            </div>

                                            <!-- Custom Pagination -->
                                            @if (method_exists($products, 'hasPages') && $products->hasPages())
                                                <nav aria-label="Phân trang">
                                                    <ul class="pagination pagination-rounded mb-0">
                                                        {{-- Previous Page Link --}}
                                                        @if (method_exists($products, 'onFirstPage') && $products->onFirstPage())
                                                            <li class="page-item disabled">
                                                                <span class="page-link" aria-hidden="true">
                                                                    <i class="bx bx-chevron-left"></i>
                                                                </span>
                                                            </li>
                                                        @else
                                                            <li class="page-item">
                                                                <a class="page-link"
                                                                    href="{{ $products->appends(request()->query())->previousPageUrl() }}"
                                                                    rel="prev" aria-label="Trang trước">
                                                                    <i class="bx bx-chevron-left"></i>
                                                                </a>
                                                            </li>
                                                        @endif

                                                        {{-- Pagination Elements --}}
                                                        @if (method_exists($products, 'getUrlRange'))
                                                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                                                @if ($page == $products->currentPage())
                                                                    <li class="page-item active">
                                                                        <span class="page-link">{{ $page }}</span>
                                                                    </li>
                                                                @else
                                                                    <li class="page-item">
                                                                        <a class="page-link"
                                                                            href="{{ $products->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                        {{-- Next Page Link --}}
                                                        @if (method_exists($products, 'hasMorePages') && $products->hasMorePages())
                                                            <li class="page-item">
                                                                <a class="page-link"
                                                                    href="{{ $products->appends(request()->query())->nextPageUrl() }}"
                                                                    rel="next" aria-label="Trang sau">
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
                                            <h5 class="text-muted">
                                                @if (isset($trash) && $trash)
                                                    Không có sản phẩm nào trong thùng rác
                                                @else
                                                    Không tìm thấy sản phẩm nào
                                                @endif
                                            </h5>
                                            <p class="text-muted">
                                                @if (isset($trash) && $trash)
                                                    Không có sản phẩm nào đã xoá.
                                                @else
                                                    Chưa có sản phẩm nào trong hệ thống.
                                                @endif
                                            </p>
                                            @if (!isset($trash) || !$trash)
                                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                                    <i class="bx bx-plus me-1"></i>Thêm sản phẩm đầu tiên
                                                </a>
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
        </div>
        <!-- END Wrapper -->

        <!-- Vendor Javascript (Require in all Page) -->
        <script src="{{ asset('admin/assets/js/vendor.js') }}"></script>
        <!-- App Javascript (Require in all Page) -->
        <script src="{{ asset('admin/assets/js/app.js') }}"></script>

        <!-- Custom JavaScript for this page -->
        <script>
            // Select all checkboxes functionality
            document.getElementById('customCheckAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.product-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Individual checkbox change handler
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allCheckboxes = document.querySelectorAll('.product-checkbox');
                    const checkedCheckboxes = document.querySelectorAll('.product-checkbox:checked');
                    const selectAllCheckbox = document.getElementById('customCheckAll');

                    selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
                    selectAllCheckbox.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length <
                        allCheckboxes.length;
                });
            });
        </script>
    </body>
@endsection