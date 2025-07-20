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

                <!-- Form tìm kiếm -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('variants.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="search_product" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="search_product" name="search_product"
                                    value="{{ request('search_product') }}" placeholder="Search by product name...">
                            </div>

                            <div class="col-md-2">
                                <label for="search_price_min" class="form-label">Min Price</label>
                                <input type="number" class="form-control" id="search_price_min" name="search_price_min"
                                    value="{{ request('search_price_min') }}" placeholder="Min price">
                            </div>

                            <div class="col-md-2">
                                <label for="search_price_max" class="form-label">Max Price</label>
                                <input type="number" class="form-control" id="search_price_max" name="search_price_max"
                                    value="{{ request('search_price_max') }}" placeholder="Max price">
                            </div>

                            <div class="col-md-2">
                                <label for="search_status" class="form-label">Status</label>
                                <select class="form-select" id="search_status" name="search_status">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('search_status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('search_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label d-block">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-search me-1"></i>Search
                                    </button>
                                    <a href="{{ route('variants.index') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-refresh me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Hiển thị kết quả tìm kiếm nếu có -->
                        @if (request()->hasAny(['search_product', 'search_price_min', 'search_price_max', 'search_status']))
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="text-muted">Search filters:</span>

                                    @if (request('search_product'))
                                        <span class="badge bg-primary-subtle text-primary">
                                            Product: "{{ request('search_product') }}"
                                            <a href="{{ route('variants.index', request()->except('search_product')) }}"
                                                class="text-decoration-none ms-1">×</a>
                                        </span>
                                    @endif

                                    @if (request('search_price_min'))
                                        <span class="badge bg-info-subtle text-info">
                                            Min Price: "{{ request('search_price_min') }}"
                                            <a href="{{ route('variants.index', request()->except('search_price_min')) }}"
                                                class="text-decoration-none ms-1">×</a>
                                        </span>
                                    @endif

                                    @if (request('search_price_max'))
                                        <span class="badge bg-info-subtle text-info">
                                            Max Price: "{{ request('search_price_max') }}"
                                            <a href="{{ route('variants.index', request()->except('search_price_max')) }}"
                                                class="text-decoration-none ms-1">×</a>
                                        </span>
                                    @endif

                                    @if (request('search_status'))
                                        <span class="badge bg-success-subtle text-success">
                                            Status: "{{ request('search_status') }}"
                                            <a href="{{ route('variants.index', request()->except('search_status')) }}"
                                                class="text-decoration-none ms-1">×</a>
                                        </span>
                                    @endif

                                    <a href="{{ route('variants.index') }}"
                                        class="btn btn-sm btn-outline-secondary">Clear all</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                <h4 class="card-title flex-grow-1">All Variants List</h4>
                                <a href="{{ route('variants.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus me-1"></i>Add Variant
                                </a>
                                <a href="{{ route('variants.trash') }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bx bx-trash me-1"></i>Trash
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" class="dropdown-item">
                                            <i class="bx bx-download me-2"></i>Download
                                        </a>
                                        <a href="#!" class="dropdown-item">
                                            <i class="bx bx-export me-2"></i>Export
                                        </a>
                                        <a href="#!" class="dropdown-item">
                                            <i class="bx bx-import me-2"></i>Import
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
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Stock</th>
                                                    <th>Attributes</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
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
                                                                    <h6 class="mb-0 fw-semibold">
                                                                        <a href="{{ route('products.show', $variant->product->id) }}" 
                                                                           class="text-decoration-none">
                                                                            {{ $variant->product->name }}
                                                                        </a>
                                                                    </h6>
                                                                    <small class="text-muted">ID: {{ $variant->product->id }}</small>
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
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input status-toggle" type="checkbox" 
                                                                       id="status{{ $variant->id }}"
                                                                       data-variant-id="{{ $variant->id }}"
                                                                       {{ $variant->status == 'active' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="status{{ $variant->id }}">
                                                                    {{ ucfirst($variant->status) }}
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">
                                                                {{ $variant->created_at->format('M d, Y') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{ route('variants.show', $variant->id) }}" 
                                                                       class="dropdown-item">
                                                                        <i class="bx bx-show me-2"></i>View
                                                                    </a>
                                                                    <a href="{{ route('variants.edit', $variant->id) }}" 
                                                                       class="dropdown-item">
                                                                        <i class="bx bx-edit me-2"></i>Edit
                                                                    </a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <form action="{{ route('variants.destroy', $variant->id) }}" 
                                                                          method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger" 
                                                                                onclick="return confirm('Are you sure you want to delete this variant?')">
                                                                            <i class="bx bx-trash me-2"></i>Delete
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
                                            {{ $variants->appends(request()->query())->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bx bx-package display-1 text-muted"></i>
                                        </div>
                                        <h5 class="text-muted">No variants found</h5>
                                        <p class="text-muted">Create your first variant to get started.</p>
                                        <a href="{{ route('variants.create') }}" class="btn btn-primary">
                                            <i class="bx bx-plus me-1"></i>Add Variant
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
        // Status toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const statusToggles = document.querySelectorAll('.status-toggle');
            
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
        });
    </script>
</body>
@endsection 