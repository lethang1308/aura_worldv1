@extends('admins.layouts.default')

@section('content')
<body>

    <!-- START Wrapper -->
    <div class="wrapper">
        <!-- Right Sidebar (Theme Settings) -->
        <div>
            <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="theme-settings-offcanvas">
                <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
                    <h5 class="text-white m-0">Theme Settings</h5>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <div class="offcanvas-body p-0">
                    <div data-simplebar class="h-100">
                        <div class="p-3 settings-bar">

                            <div>
                                <h5 class="mb-3 font-16 fw-semibold">Color Scheme</h5>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-bs-theme"
                                        id="layout-color-light" value="light">
                                    <label class="form-check-label" for="layout-color-light">Light</label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-bs-theme"
                                        id="layout-color-dark" value="dark">
                                    <label class="form-check-label" for="layout-color-dark">Dark</label>
                                </div>
                            </div>

                            <div>
                                <h5 class="my-3 font-16 fw-semibold">Topbar Color</h5>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-topbar-color"
                                        id="topbar-color-light" value="light">
                                    <label class="form-check-label" for="topbar-color-light">Light</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-topbar-color"
                                        id="topbar-color-dark" value="dark">
                                    <label class="form-check-label" for="topbar-color-dark">Dark</label>
                                </div>
                            </div>

                            <div>
                                <h5 class="my-3 font-16 fw-semibold">Menu Color</h5>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-menu-color"
                                        id="leftbar-color-light" value="light">
                                    <label class="form-check-label" for="leftbar-color-light">
                                        Light
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-menu-color"
                                        id="leftbar-color-dark" value="dark">
                                    <label class="form-check-label" for="leftbar-color-dark">
                                        Dark
                                    </label>
                                </div>
                            </div>

                            <div>
                                <h5 class="my-3 font-16 fw-semibold">Sidebar Size</h5>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-menu-size"
                                        id="leftbar-size-default" value="default">
                                    <label class="form-check-label" for="leftbar-size-default">
                                        Default
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-menu-size"
                                        id="leftbar-size-small" value="condensed">
                                    <label class="form-check-label" for="leftbar-size-small">
                                        Condensed
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-menu-size"
                                        id="leftbar-size-hidden" value="hidden">
                                    <label class="form-check-label" for="leftbar-size-hidden">
                                        Hidden
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-menu-size"
                                        id="leftbar-size-small-hover-active" value="sm-hover-active">
                                    <label class="form-check-label" for="leftbar-size-small-hover-active">
                                        Small Hover Active
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="data-menu-size"
                                        id="leftbar-size-small-hover" value="sm-hover">
                                    <label class="form-check-label" for="leftbar-size-small-hover">
                                        Small Hover
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="offcanvas-footer border-top p-3 text-center">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-danger w-100" id="reset-layout">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="page-content">
            <!-- Start Container Fluid -->
            <div class="container-fluid">
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                <h4 class="card-title flex-grow-1">All Product List</h4>

                                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus me-1"></i>Add Product
                                </a>

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                                @if($products->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0 table-hover table-centered">
                                            <thead class="bg-light-subtle">
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="form-check ms-1">
                                                            <input type="checkbox" class="form-check-input" id="customCheckAll">
                                                            <label class="form-check-label" for="customCheckAll"></label>
                                                        </div>
                                                    </th>
                                                    <th>Product Name</th>
                                                    <th>Price</th>
                                                    <th>Category</th>
                                                    <th>Description</th>
                                                    <th>Created Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products as $product)
                                                <tr>
                                                    <td>
                                                        <div class="form-check ms-1">
                                                            <input type="checkbox" class="form-check-input product-checkbox" 
                                                                   id="customCheck{{ $product->id }}" value="{{ $product->id }}">
                                                            <label class="form-check-label" for="customCheck{{ $product->id }}">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                                <img src="{{ asset('admin/assets/images/product/p-12.png') }}" alt="{{ $product->name }}" class="avatar-md">
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('products.show', $product->id) }}" class="text-dark fw-medium fs-15">
                                                                    {{ Str::limit($product->name, 30) }}
                                                                </a>
                                                                <p class="text-muted mb-0 mt-1 fs-13">
                                                                    <span>ID: </span>#{{ $product->id }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-medium text-success">${{ number_format($product->base_price, 2) }}</span>
                                                    </td>
                                                    <td>
                                                        @if($product->category)
                                                            <span class="badge bg-success-subtle text-success">{{ $product->category->name }}</span>
                                                        @else
                                                            <span class="badge bg-secondary-subtle text-secondary">No Category</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">
                                                            {{ $product->description ? Str::limit($product->description, 50) : 'No description' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-13">
                                                            {{ $product->created_at->format('M d, Y') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="#!" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                               data-bs-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('products.show', $product->id) }}">
                                                                        <i class="bx bx-show me-2"></i>View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">
                                                                        <i class="bx bx-edit me-2"></i>Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                                                                          onsubmit="return confirm('Are you sure you want to delete this product?')" 
                                                                          style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger">
                                                                            <i class="bx bx-trash me-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bx bx-package" style="font-size: 48px; color: #6c757d;"></i>
                                        </div>
                                        <h5 class="text-muted">No Products Found</h5>
                                        <p class="text-muted">There are no products in the system yet.</p>
                                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                                            <i class="bx bx-plus me-1"></i>Add First Product
                                        </a>
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
                selectAllCheckbox.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes.length;
            });
        });
    </script>

</body>
@endsection