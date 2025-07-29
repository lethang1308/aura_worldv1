@extends('admins.layouts.default')

@section('content')
<body>
    <!-- START Wrapper -->
    <div class="wrapper">
        <div class="page-content">
            <!-- Start Container Fluid -->
            <div class="container-fluid">
                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                                 <!-- Trash Info Alert -->
                 @php
                     $deletedCount = \App\Models\Variant::onlyTrashed()->count();
                 @endphp
                 @if($deletedCount > 0 && request('show_deleted') != '1')
                     <div class="alert alert-info alert-dismissible fade show" role="alert">
                         <i class="bx bx-info-circle me-2"></i>
                         <strong>Thông Báo Thùng Rác:</strong> Bạn có {{ $deletedCount }} biến thể đã xóa trong thùng rác. 
                         <a href="{{ route('variants.index', ['show_deleted' => '1']) }}" class="alert-link">Xem thùng rác</a> để khôi phục hoặc xóa vĩnh viễn.
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>
                 @endif

                <!-- Form tìm kiếm -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('variants.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="search_product" class="form-label">Tên Sản Phẩm</label>
                                <input type="text" class="form-control" id="search_product" name="search_product"
                                    value="{{ request('search_product') }}" placeholder="Tìm kiếm theo tên sản phẩm...">
                            </div>

                            <div class="col-md-2">
                                <label for="search_price_min" class="form-label">Giá Tối Thiểu</label>
                                <input type="number" class="form-control" id="search_price_min" name="search_price_min"
                                    value="{{ request('search_price_min') }}" placeholder="Giá tối thiểu">
                            </div>

                            <div class="col-md-2">
                                <label for="search_price_max" class="form-label">Giá Tối Đa</label>
                                <input type="number" class="form-control" id="search_price_max" name="search_price_max"
                                    value="{{ request('search_price_max') }}" placeholder="Giá tối đa">
                            </div>

                            <div class="col-md-2">
                                <label for="search_status" class="form-label">Trạng Thái</label>
                                <select class="form-select" id="search_status" name="search_status">
                                    <option value="">Tất Cả Trạng Thái</option>
                                    <option value="active" {{ request('search_status') == 'active' ? 'selected' : '' }}>Hoạt Động</option>
                                    <option value="inactive" {{ request('search_status') == 'inactive' ? 'selected' : '' }}>Không Hoạt Động</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label d-block">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-search me-1"></i>Tìm Kiếm
                                    </button>
                                    <a href="{{ route('variants.index') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-refresh me-1"></i>Đặt Lại
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Hiển thị kết quả tìm kiếm nếu có -->
                        @if (request()->hasAny(['search_product', 'search_price_min', 'search_price_max', 'search_status']))
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="text-muted">Bộ lọc tìm kiếm:</span>

                                    @if (request('search_product'))
                                        <span class="badge bg-primary-subtle text-primary">
                                            Sản phẩm: "{{ request('search_product') }}"
                                            <a href="{{ route('variants.index', request()->except('search_product')) }}"
                                                class="text-decoration-none ms-1">×</a>
                                        </span>
                                    @endif

                                    @if (request('search_price_min'))
                                        <span class="badge bg-info-subtle text-info">
                                            Giá tối thiểu: "{{ request('search_price_min') }}"
                                            <a href="{{ route('variants.index', request()->except('search_price_min')) }}"
                                                class="text-decoration-none ms-1">×</a>
                                        </span>
                                    @endif

                                    @if (request('search_price_max'))
                                        <span class="badge bg-info-subtle text-info">
                                            Giá tối đa: "{{ request('search_price_max') }}"
                                            <a href="{{ route('variants.index', request()->except('search_price_max')) }}"
                                                class="text-decoration-none ms-1">×</a>
                                        </span>
                                    @endif

                                    @if (request('search_status'))
                                        <span class="badge bg-success-subtle text-success">
                                            Trạng thái: "{{ request('search_status') }}"
                                            <a href="{{ route('variants.index', request()->except('search_status')) }}"
                                                class="text-decoration-none ms-1">×</a>
                                        </span>
                                    @endif

                                    <a href="{{ route('variants.index') }}"
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
                                <h4 class="card-title flex-grow-1">
                                    @if(request('show_deleted') == '1')
                                        <i class="bx bx-trash me-2 text-warning"></i>Danh Sách Biến Thể Đã Xóa
                                    @else
                                        Danh Sách Tất Cả Biến Thể
                                    @endif
                                </h4>
                                <a href="{{ route('variants.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus me-1"></i>Thêm Biến Thể
                                </a>
                                @if(request('show_deleted') == '1')
                                    <a href="{{ route('variants.index') }}" class="btn btn-sm btn-outline-success">
                                        <i class="bx bx-list-ul me-1"></i>Hiển Thị Hoạt Động
                                    </a>
                                @else
                                    <a href="{{ route('variants.index', ['show_deleted' => '1']) }}" 
                                       class="btn btn-sm btn-outline-warning position-relative" 
                                       data-bs-toggle="tooltip" data-bs-placement="top" 
                                       title="Xem biến thể đã xóa ({{ $deletedCount }} mục)">
                                        <i class="bx bx-trash me-1"></i>Thùng Rác
                                        @if($deletedCount > 0)
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger animate__animated animate__pulse">
                                                {{ $deletedCount }}
                                            </span>
                                        @endif
                                    </a>
                                @endif
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" class="dropdown-item">
                                            <i class="bx bx-download me-2"></i>Tải Xuống
                                        </a>
                                        <a href="#!" class="dropdown-item">
                                            <i class="bx bx-export me-2"></i>Xuất
                                        </a>
                                        <a href="#!" class="dropdown-item">
                                            <i class="bx bx-import me-2"></i>Nhập
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @if ($variants->count() > 0)
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
                                                    <th>Sản Phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Tồn Kho</th>
                                                    <th>Thuộc Tính</th>
                                                    <th>Trạng Thái</th>
                                                    <th>Ngày Tạo</th>
                                                    <th style="width: 150px;">Hành Động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($variants as $variant)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check ms-1">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="customCheck{{ $variant->id }}">
                                                                <label class="form-check-label"
                                                                    for="customCheck{{ $variant->id }}"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1">
                                                                                                                                         <h6 class="mb-0 fw-semibold">
                                                                         @if($variant->product)
                                                                             @if(request('show_deleted') == '1')
                                                                                 <span class="text-muted">{{ $variant->product->name }}</span>
                                                                             @else
                                                                                 <a href="{{ route('products.show', $variant->product->id) }}" 
                                                                                    class="text-decoration-none">
                                                                                     {{ $variant->product->name }}
                                                                                 </a>
                                                                             @endif
                                                                         @else
                                                                             <span class="text-muted">Không tìm thấy sản phẩm</span>
                                                                         @endif
                                                                     </h6>
                                                                    <small class="text-muted">
                                                                        @if($variant->product)
                                                                            ID: {{ $variant->product->id }}
                                                                        @else
                                                                            ID Sản phẩm: N/A
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fw-semibold text-success">
                                                                ${{ number_format($variant->price, 2) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $variant->stock_quantity > 0 ? 'success' : 'danger' }}-subtle 
                                                                       text-{{ $variant->stock_quantity > 0 ? 'success' : 'danger' }}">
                                                                {{ $variant->stock_quantity }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                                                                                         @if($variant->attributesValue->count() > 0)
                                                                 <div class="d-flex flex-wrap gap-1">
                                                                     @foreach($variant->attributesValue as $attrValue)
                                                                         @if(request('show_deleted') == '1')
                                                                             <span class="badge bg-light text-muted">
                                                                                 {{ $attrValue->attribute->name ?? 'Thuộc tính đã xóa' }}: {{ $attrValue->value }}
                                                                             </span>
                                                                         @else
                                                                             <span class="badge bg-light text-dark">
                                                                                 {{ $attrValue->attribute->name }}: {{ $attrValue->value }}
                                                                             </span>
                                                                         @endif
                                                                     @endforeach
                                                                 </div>
                                                             @else
                                                                 <span class="text-muted">Không có thuộc tính</span>
                                                             @endif
                                                        </td>
                                                                                                                 <td>
                                                             @if(request('show_deleted') == '1')
                                                                 <span class="badge bg-danger">Đã Xóa</span>
                                                             @else
                                                                 <div class="form-check form-switch">
                                                                     <input class="form-check-input status-toggle" type="checkbox" 
                                                                            id="status{{ $variant->id }}"
                                                                            data-variant-id="{{ $variant->id }}"
                                                                            {{ $variant->status == 'active' ? 'checked' : '' }}>
                                                                     <label class="form-check-label" for="status{{ $variant->id }}">
                                                                         {{ ucfirst($variant->status) }}
                                                                     </label>
                                                                 </div>
                                                             @endif
                                                         </td>
                                                                                                                 <td>
                                                             <span class="text-muted">
                                                                 @if(request('show_deleted') == '1')
                                                                     <span class="text-danger">
                                                                         Đã xóa: {{ $variant->deleted_at->format('M d, Y') }}
                                                                     </span>
                                                                 @else
                                                                     {{ $variant->created_at->format('M d, Y') }}
                                                                 @endif
                                                             </span>
                                                         </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                                                                                 <div class="dropdown-menu dropdown-menu-end">
                                                                     @if(request('show_deleted') == '1')
                                                                         <a href="{{ route('variants.show', $variant->id) }}" 
                                                                            class="dropdown-item">
                                                                             <i class="bx bx-show me-2"></i>Xem
                                                                         </a>
                                                                         <div class="dropdown-divider"></div>
                                                                         <form action="{{ route('variants.restore', $variant->id) }}" 
                                                                               method="POST" class="d-inline">
                                                                             @csrf
                                                                             @method('PATCH')
                                                                             <button type="submit" class="dropdown-item text-success" 
                                                                                     onclick="return confirm('Bạn có chắc chắn muốn khôi phục biến thể này?')">
                                                                                 <i class="bx bx-refresh me-2"></i>Khôi Phục
                                                                             </button>
                                                                         </form>
                                                                         <form action="{{ route('variants.forceDelete', $variant->id) }}" 
                                                                               method="POST" class="d-inline">
                                                                             @csrf
                                                                             @method('DELETE')
                                                                             <button type="submit" class="dropdown-item text-danger" 
                                                                                     onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn biến thể này? Hành động này không thể hoàn tác.')">
                                                                                 <i class="bx bx-trash me-2"></i>Xóa Vĩnh Viễn
                                                                             </button>
                                                                         </form>
                                                                     @else
                                                                         <a href="{{ route('variants.show', $variant->id) }}" 
                                                                            class="dropdown-item">
                                                                             <i class="bx bx-show me-2"></i>Xem
                                                                         </a>
                                                                         <a href="{{ route('variants.edit', $variant->id) }}" 
                                                                            class="dropdown-item">
                                                                             <i class="bx bx-edit me-2"></i>Sửa
                                                                         </a>
                                                                         <div class="dropdown-divider"></div>
                                                                         <form action="{{ route('variants.destroy', $variant->id) }}" 
                                                                               method="POST" class="d-inline">
                                                                             @csrf
                                                                             @method('DELETE')
                                                                             <button type="submit" class="dropdown-item text-danger" 
                                                                                     onclick="return confirm('Bạn có chắc chắn muốn xóa biến thể này?')">
                                                                                 <i class="bx bx-trash me-2"></i>Xóa
                                                                             </button>
                                                                         </form>
                                                                     @endif
                                                                 </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted">
                                            Hiển thị {{ $variants->firstItem() }} đến {{ $variants->lastItem() }} 
                                            trong tổng số {{ $variants->total() }} mục
                                        </div>
                                        <div>
                                            {{ $variants->appends(request()->query())->links() }}
                                        </div>
                                    </div>
                                                                 @else
                                     <div class="text-center py-5">
                                         <div class="mb-3">
                                             @if(request('show_deleted') == '1')
                                                 <i class="bx bx-trash display-1 text-muted"></i>
                                             @else
                                                 <i class="bx bx-package display-1 text-muted"></i>
                                             @endif
                                         </div>
                                         <h5 class="text-muted">
                                             @if(request('show_deleted') == '1')
                                                 Không tìm thấy biến thể đã xóa
                                             @else
                                                 Không tìm thấy biến thể
                                             @endif
                                         </h5>
                                         <p class="text-muted">
                                             @if(request('show_deleted') == '1')
                                                 Chưa có biến thể nào được xóa.
                                             @else
                                                 Tạo biến thể đầu tiên để bắt đầu.
                                             @endif
                                         </p>
                                         @if(request('show_deleted') != '1')
                                             <a href="{{ route('variants.create') }}" class="btn btn-primary">
                                                 <i class="bx bx-plus me-1"></i>Thêm Biến Thể
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

    <script>
        // Status toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

                         const statusToggles = document.querySelectorAll('.status-toggle');
             
             // Chỉ chạy status toggle khi không xem variants đã xóa
             @if(request('show_deleted') != '1')
             statusToggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const variantId = this.dataset.variantId;
                    const status = this.checked ? 'active' : 'inactive';
                    
                    fetch(`/variants/${variantId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ status: status })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            const alert = document.createElement('div');
                            alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
                            alert.innerHTML = `
                                ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;
                            document.body.appendChild(alert);
                            
                            setTimeout(() => {
                                alert.remove();
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                                                 // Revert the toggle
                         this.checked = !this.checked;
                     });
                 });
             });
             @endif
        });
    </script>
</body>
@endsection 