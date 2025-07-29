@extends('admins.layouts.default')

@section('content')
<body>
    <div class="wrapper">
        <div class="page-content">
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

                <!-- Trash Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-trash display-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="mb-0">{{ $variants->total() }}</h4>
                                        <p class="mb-0">Biến Thể Đã Xóa</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-refresh display-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="mb-0">{{ $variants->where('product_id', '!=', null)->count() }}</h4>
                                        <p class="mb-0">Có Thể Khôi Phục</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-time display-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="mb-0">{{ $variants->where('deleted_at', '>=', now()->subDays(7))->count() }}</h4>
                                        <p class="mb-0">Đã Xóa Tuần Này</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-calendar display-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="mb-0">{{ $variants->where('deleted_at', '>=', now()->subDays(30))->count() }}</h4>
                                        <p class="mb-0">Đã Xóa Tháng Này</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">
                                    <i class="bx bx-trash me-2"></i>Biến Thể Đã Xóa
                                    <span class="badge bg-secondary ms-2">{{ $variants->total() }}</span>
                                </h4>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-success" id="restoreSelected" style="display: none;">
                                        <i class="bx bx-refresh me-1"></i>Khôi Phục Đã Chọn
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" id="deleteSelected" style="display: none;">
                                        <i class="bx bx-trash me-1"></i>Xóa Đã Chọn
                                    </button>
                                    <form action="{{ route('variants.emptyTrash') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn TẤT CẢ biến thể trong thùng rác? Hành động này không thể hoàn tác.')">
                                            <i class="bx bx-trash me-1"></i>Làm Trống Thùng Rác
                                        </button>
                                    </form>
                                    <a href="{{ route('variants.index') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bx bx-arrow-back me-1"></i>Quay Lại Danh Sách
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($variants->count() > 0)
                                    <div class="alert alert-warning">
                                        <i class="bx bx-exclamation-triangle me-2"></i>
                                        <strong>Cảnh Báo:</strong> Những biến thể này đã được xóa và có thể được khôi phục hoặc xóa vĩnh viễn.
                                    </div>

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
                                                    <th>Ngày Xóa</th>
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
                                                                    <h6 class="mb-0 fw-semibold text-muted">
                                                                        @if($variant->product)
                                                                            {{ $variant->product->name }}
                                                                        @else
                                                                            <span class="text-danger">Sản Phẩm Đã Xóa</span>
                                                                        @endif
                                                                    </h6>
                                                                    <small class="text-muted">
                                                                        @if($variant->product)
                                                                            ID: {{ $variant->product->id }}
                                                                        @else
                                                                            ID Sản phẩm: {{ $variant->product_id ?? 'N/A' }}
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
                                                                        @if($attrValue->attribute)
                                                                            <span class="badge bg-light text-dark">
                                                                                {{ $attrValue->attribute->name }}: {{ $attrValue->value }}
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-warning text-dark">
                                                                                Thuộc tính đã xóa: {{ $attrValue->value }}
                                                                            </span>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <span class="text-muted">Không có thuộc tính</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">
                                                                {{ $variant->deleted_at->format('M d, Y H:i') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <form action="{{ route('variants.restore', $variant->id) }}" 
                                                                          method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button type="submit" class="dropdown-item text-success">
                                                                            <i class="bx bx-refresh me-2"></i>Khôi Phục
                                                                        </button>
                                                                    </form>
                                                                    <div class="dropdown-divider"></div>
                                                                    <form action="{{ route('variants.forceDelete', $variant->id) }}" 
                                                                          method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger" 
                                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn biến thể này? Hành động này không thể hoàn tác.')">
                                                                            <i class="bx bx-trash me-2"></i>Xóa Vĩnh Viễn
                                                                        </button>
                                                                    </form>
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
                                            {{ $variants->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bx bx-trash display-1 text-muted"></i>
                                        </div>
                                        <h5 class="text-muted">Không tìm thấy biến thể đã xóa</h5>
                                        <p class="text-muted">Thùng rác trống. Chưa có biến thể nào được xóa.</p>
                                        <a href="{{ route('variants.index') }}" class="btn btn-primary">
                                            <i class="bx bx-arrow-back me-1"></i>Quay Lại Biến Thể
                                        </a>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Select all functionality
            const selectAllCheckbox = document.getElementById('customCheckAll');
            const individualCheckboxes = document.querySelectorAll('input[type="checkbox"]:not(#customCheckAll)');
            const restoreSelectedBtn = document.getElementById('restoreSelected');
            const deleteSelectedBtn = document.getElementById('deleteSelected');
            
            function updateActionButtons() {
                const checkedBoxes = document.querySelectorAll('input[type="checkbox"]:not(#customCheckAll):checked');
                const hasChecked = checkedBoxes.length > 0;
                
                restoreSelectedBtn.style.display = hasChecked ? 'inline-block' : 'none';
                deleteSelectedBtn.style.display = hasChecked ? 'inline-block' : 'none';
            }
            
            selectAllCheckbox.addEventListener('change', function() {
                individualCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateActionButtons();
            });

            // Update select all when individual checkboxes change
            individualCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(individualCheckboxes).every(cb => cb.checked);
                    const anyChecked = Array.from(individualCheckboxes).some(cb => cb.checked);
                    
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = anyChecked && !allChecked;
                    updateActionButtons();
                });
            });
            
            // Restore selected variants
            restoreSelectedBtn.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('input[type="checkbox"]:not(#customCheckAll):checked');
                const variantIds = Array.from(checkedBoxes).map(cb => cb.id.replace('customCheck', ''));
                
                if (variantIds.length === 0) return;
                
                if (confirm(`Bạn có chắc chắn muốn khôi phục ${variantIds.length} biến thể?`)) {
                    // Create form to submit multiple restore requests
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("variants.restoreMultiple") }}';
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PATCH';
                    form.appendChild(methodField);
                    
                    variantIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'variant_ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
            
            // Delete selected variants permanently
            deleteSelectedBtn.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('input[type="checkbox"]:not(#customCheckAll):checked');
                const variantIds = Array.from(checkedBoxes).map(cb => cb.id.replace('customCheck', ''));
                
                if (variantIds.length === 0) return;
                
                if (confirm(`Bạn có chắc chắn muốn xóa vĩnh viễn ${variantIds.length} biến thể? Hành động này không thể hoàn tác.`)) {
                    // Create form to submit multiple delete requests
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("variants.forceDeleteMultiple") }}';
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);
                    
                    variantIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'variant_ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
</body>
@endsection 