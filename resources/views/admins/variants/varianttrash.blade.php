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

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">
                                    <i class="bx bx-trash me-2"></i>Deleted Variants
                                </h4>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('variants.index') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bx bx-arrow-back me-1"></i>Back to List
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($variants->count() > 0)
                                    <div class="alert alert-warning">
                                        <i class="bx bx-exclamation-triangle me-2"></i>
                                        <strong>Warning:</strong> These variants have been deleted and can be restored or permanently deleted.
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
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Stock</th>
                                                    <th>Attributes</th>
                                                    <th>Deleted At</th>
                                                    <th style="width: 150px;">Actions</th>
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
                                                                        {{ $variant->product->name ?? 'Product Deleted' }}
                                                                    </h6>
                                                                    <small class="text-muted">ID: {{ $variant->product_id ?? 'N/A' }}</small>
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
                                                                        <span class="badge bg-light text-dark">
                                                                            {{ $attrValue->attribute->name }}: {{ $attrValue->value }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <span class="text-muted">No attributes</span>
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
                                                                            <i class="bx bx-refresh me-2"></i>Restore
                                                                        </button>
                                                                    </form>
                                                                    <div class="dropdown-divider"></div>
                                                                    <form action="{{ route('variants.forceDelete', $variant->id) }}" 
                                                                          method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger" 
                                                                                onclick="return confirm('Are you sure you want to permanently delete this variant? This action cannot be undone.')">
                                                                            <i class="bx bx-trash me-2"></i>Delete Permanently
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
                                            Showing {{ $variants->firstItem() }} to {{ $variants->lastItem() }} 
                                            of {{ $variants->total() }} entries
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
                                        <h5 class="text-muted">No deleted variants found</h5>
                                        <p class="text-muted">The trash is empty. No variants have been deleted.</p>
                                        <a href="{{ route('variants.index') }}" class="btn btn-primary">
                                            <i class="bx bx-arrow-back me-1"></i>Back to Variants
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
            
            selectAllCheckbox.addEventListener('change', function() {
                individualCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Update select all when individual checkboxes change
            individualCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(individualCheckboxes).every(cb => cb.checked);
                    const anyChecked = Array.from(individualCheckboxes).some(cb => cb.checked);
                    
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = anyChecked && !allChecked;
                });
            });
        });
    </script>
</body>
@endsection 