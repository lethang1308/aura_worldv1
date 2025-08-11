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
                                <h4 class="card-title">Tạo Biến Thể Mới</h4>
                                <a href="{{ route('variants.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-1"></i>Quay Lại Danh Sách
                                </a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('variants.store') }}" method="POST" id="variantForm">
                                    @csrf
                                    
                                    <div class="row">
                                        <!-- Product Selection -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="product_id" class="form-label">Sản Phẩm <span class="text-danger">*</span></label>
                                                <select class="form-select @error('product_id') is-invalid @enderror" 
                                                        id="product_id" name="product_id">
                                                    <option value="">Chọn Sản Phẩm</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" 
                                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }} (ID: {{ $product->id }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" step="0.01" min="0" 
                                                           class="form-control @error('price') is-invalid @enderror" 
                                                           id="price" name="price" value="{{ old('price') }}" 
                                                           placeholder="0.00">
                                                </div>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Stock Quantity -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="stock_quantity" class="form-label">Số Lượng Tồn Kho <span class="text-danger">*</span></label>
                                                <input type="number" min="0" 
                                                       class="form-control @error('stock_quantity') is-invalid @enderror" 
                                                       id="stock_quantity" name="stock_quantity" 
                                                       value="{{ old('stock_quantity') }}" placeholder="0">
                                                @error('stock_quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                                                <select class="form-select @error('status') is-invalid @enderror" 
                                                        id="status" name="status">
                                                    <option value="">Chọn Trạng Thái</option>
                                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt Động</option>
                                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không Hoạt Động</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Attributes Section -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Thuộc Tính <span class="text-danger">*</span></label>
                                                <div class="alert alert-info">
                                                    <i class="bx bx-info-circle me-2"></i>
                                                    Chọn ít nhất một giá trị thuộc tính cho biến thể này.
                                                </div>
                                                
                                                @error('attribute_values')
                                                    <div class="alert alert-danger">
                                                        <i class="bx bx-error-circle me-2"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <div id="attributes-container">
                                                    @foreach($attributes as $attribute)
                                                        <div class="card mb-3">
                                                            <div class="card-header">
                                                                <h6 class="mb-0">{{ $attribute->name }}</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @foreach($attribute->attributeValues as $attrValue)
                                                                        <div class="col-md-3 mb-2">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" 
                                                                                       name="attribute_values[]" 
                                                                                       value="{{ $attrValue->id }}" 
                                                                                       id="attr_{{ $attrValue->id }}"
                                                                                       {{ in_array($attrValue->id, old('attribute_values', [])) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="attr_{{ $attrValue->id }}">
                                                                                    {{ $attrValue->value }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bx bx-save me-1"></i>Tạo Biến Thể
                                                </button>
                                                <a href="{{ route('variants.index') }}" class="btn btn-outline-secondary">
                                                    <i class="bx bx-x me-1"></i>Hủy
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('variantForm');
            const attributeCheckboxes = document.querySelectorAll('input[name="attribute_values[]"]');
            
            // Validate form before submit
            form.addEventListener('submit', function(e) {
                const checkedAttributes = document.querySelectorAll('input[name="attribute_values[]"]:checked');
                
                if (checkedAttributes.length === 0) {
                    e.preventDefault();
                    alert('Vui lòng chọn ít nhất một giá trị thuộc tính.');
                    return false;
                }
            });

            // Product change handler (for future AJAX functionality)
            const productSelect = document.getElementById('product_id');
            productSelect.addEventListener('change', function() {
                const productId = this.value;
                if (productId) {
                    // You can add AJAX call here to load product-specific attributes
                    console.log('Selected product ID:', productId);
                }
            });

            // Price formatting
            const priceInput = document.getElementById('price');
            priceInput.addEventListener('blur', function() {
                if (this.value) {
                    this.value = parseFloat(this.value).toFixed(2);
                }
            });
        });
    </script>
</body>
@endsection 