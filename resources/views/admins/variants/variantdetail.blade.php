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
                                <h4 class="card-title">Chi Tiết Biến Thể</h4>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('variants.edit', $variant->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bx bx-edit me-1"></i>Sửa
                                    </a>
                                    <a href="{{ route('variants.index') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bx bx-arrow-back me-1"></i>Quay Lại Danh Sách
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Basic Information -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="bx bx-info-circle me-2"></i>Thông Tin Cơ Bản
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-sm-4">
                                                        <strong>ID Biến Thể:</strong>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <span class="badge bg-primary">{{ $variant->id }}</span>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-sm-4">
                                                        <strong>Sản Phẩm:</strong>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <a href="{{ route('products.show', $variant->product->id) }}" 
                                                           class="text-decoration-none">
                                                            {{ $variant->product->name }}
                                                        </a>
                                                        <small class="text-muted d-block">ID: {{ $variant->product->id }}</small>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-sm-4">
                                                        <strong>Giá:</strong>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <span class="fw-bold text-success fs-5">
                                                            ${{ number_format($variant->price, 2) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-sm-4">
                                                        <strong>Số Lượng Tồn Kho:</strong>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <span class="badge bg-{{ $variant->stock_quantity > 0 ? 'success' : 'danger' }}-subtle 
                                                                   text-{{ $variant->stock_quantity > 0 ? 'success' : 'danger' }} fs-6">
                                                            {{ $variant->stock_quantity }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-sm-4">
                                                        <strong>Trạng Thái:</strong>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <span class="badge bg-{{ $variant->status == 'active' ? 'success' : 'secondary' }}-subtle 
                                                                   text-{{ $variant->status == 'active' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($variant->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Attributes Information -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="bx bx-tag me-2"></i>Thuộc Tính
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                @if($variant->attributesValue->count() > 0)
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($variant->attributesValue as $attrValue)
                                                            <div class="border rounded p-2 mb-2" style="min-width: 150px;">
                                                                <div class="fw-bold text-primary">{{ $attrValue->attribute->name }}</div>
                                                                <div class="text-dark">{{ $attrValue->value }}</div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="text-center py-3">
                                                        <i class="bx bx-package display-4 text-muted"></i>
                                                        <p class="text-muted mt-2">Không có thuộc tính nào được gán cho biến thể này.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Information -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="bx bx-package me-2"></i>Thông Tin Sản Phẩm
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <strong>Tên Sản Phẩm:</strong>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                {{ $variant->product->name }}
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <strong>Danh Mục:</strong>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                @if($variant->product->category)
                                                                    <a href="{{ route('categories.edit', $variant->product->category->id) }}" 
                                                                       class="text-decoration-none">
                                                                        {{ $variant->product->category->category_name }}
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">Không có danh mục</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <strong>Thương Hiệu:</strong>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                @if($variant->product->brand)
                                                                    <a href="{{ route('brands.edit', $variant->product->brand->id) }}" 
                                                                       class="text-decoration-none">
                                                                        {{ $variant->product->brand->name }}
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">Không có thương hiệu</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <strong>Giá Cơ Bản:</strong>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <span class="text-muted">${{ number_format($variant->product->base_price, 2) }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <strong>Mô Tả:</strong>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                @if($variant->product->description)
                                                                    <p class="text-muted mb-0">{{ Str::limit($variant->product->description, 100) }}</p>
                                                                @else
                                                                    <span class="text-muted">Không có mô tả</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <strong>Ngày Tạo:</strong>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <span class="text-muted">{{ $variant->created_at->format('M d, Y H:i') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Timestamps -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="bx bx-time me-2"></i>Thời Gian
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-5">
                                                                <strong>Ngày Tạo:</strong>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <span class="text-muted">{{ $variant->created_at->format('M d, Y H:i:s') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-5">
                                                                <strong>Ngày Cập Nhật:</strong>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <span class="text-muted">{{ $variant->updated_at->format('M d, Y H:i:s') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-5">
                                                                <strong>Trạng Thái:</strong>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <span class="badge bg-{{ $variant->status == 'active' ? 'success' : 'secondary' }}-subtle 
                                                                           text-{{ $variant->status == 'active' ? 'success' : 'secondary' }}">
                                                                    {{ ucfirst($variant->status) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('variants.edit', $variant->id) }}" class="btn btn-primary">
                                                <i class="bx bx-edit me-1"></i>Sửa Biến Thể
                                            </a>
                                            <a href="{{ route('variants.index') }}" class="btn btn-outline-secondary">
                                                <i class="bx bx-arrow-back me-1"></i>Quay Lại Danh Sách
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="if(confirm('Bạn có chắc chắn muốn xóa biến thể này?')) { 
                                                        document.getElementById('deleteForm').submit(); 
                                                    }">
                                                <i class="bx bx-trash me-1"></i>Xóa
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Form -->
                                <form id="deleteForm" action="{{ route('variants.destroy', $variant->id) }}" 
                                      method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection 