@extends('admins.layouts.default')

@section('content')

    <body>
        <div class="wrapper">
            <div class="page-content">
                <div class="container-xxl">
                    <div class="row">

                        {{-- Cột bên trái: Xem trước và nút hành động --}}
                        <div class="col-xl-3 col-lg-4">
                            <div class="card">
                                {{-- Khu vực xem trước hình ảnh --}}
                                <div class="card-body">
                                    <label class="form-label">Xem trước hình ảnh đã chọn</label>
                                    <div id="image-preview" class="d-flex flex-wrap gap-2"></div>

                                    {{-- Nút tùy chỉnh để kích hoạt input chọn file --}}
                                    <div class="mb-3 mt-3">
                                        <label for="product-images" class="btn btn-outline-primary w-100">
                                            Chọn hình ảnh
                                        </label>
                                    </div>
                                </div>

                                {{-- Nút hành động --}}
                                <div class="card-footer bg-light-subtle">
                                    <div class="row g-2">
                                        <div class="col-lg-6">
                                            <button type="submit" form="product-form"
                                                class="btn btn-outline-secondary w-100">
                                                {{ isset($product) ? 'Cập nhật sản phẩm' : 'Tạo sản phẩm' }}
                                            </button>
                                        </div>
                                        <div class="col-lg-6">
                                            <a href="{{ route('products.index') }}" class="btn btn-primary w-100">Hủy</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Cột bên phải: Form --}}
                        <div class="col-xl-9 col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Thông tin sản phẩm</h4>
                                </div>
                                <div class="card-body">
                                    <form id="product-form" action="{{ route('products.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        {{-- Tên sản phẩm --}}
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                                    <input type="text" id="product-name" name="name"
                                                        class="form-control" placeholder="Nhập tên sản phẩm"
                                                        value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Danh mục --}}
                                            <div class="col-lg-6">
                                                <label for="product-categories" class="form-label">Danh mục sản phẩm <span class="text-danger">*</span></label>
                                                <select class="form-control" id="product-categories" name="category_id"
                                                    >
                                                    <option value="">Chọn danh mục</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Thương hiệu --}}
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="brand_id" class="form-label">Thương hiệu</label>
                                                <select class="form-control" id="brand_id" name="brand_id">
                                                    <option value="">Chọn thương hiệu</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}"
                                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                            {{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('brand_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Mô tả --}}
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Mô tả</label>
                                                    <textarea class="form-control bg-light-subtle" id="description" name="description" rows="7"
                                                        placeholder="Mô tả ngắn về sản phẩm">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Giá --}}
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label for="product-price" class="form-label">Giá (VND) <span class="text-danger">*</span></label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text fs-20">₫</span>
                                                    <input type="number" id="product-price" name="base_price"
                                                        class="form-control" placeholder="Nhập giá"
                                                        value="{{ old('base_price') }}">
                                                </div>
                                                @error('base_price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Biến thể sản phẩm --}}
                                        <div class="row mt-4">
                                            <div class="col-lg-12">
                                                <label class="form-label">Biến thể sản phẩm</label>
                                                <div id="variants-container">
                                                    <!-- Các dòng biến thể sẽ được thêm ở đây -->
                                                </div>
                                                <button type="button" class="btn btn-outline-primary mt-2" id="add-variant-btn">Thêm biến thể</button>
                                            </div>
                                        </div>

                                        {{-- Input File Ẩn --}}
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3 d-none">
                                                    <input type="file" name="images[]" id="product-images"
                                                        class="form-control" multiple accept="image/*">
                                                    @error('images.*')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div> <!-- .row -->
                </div> <!-- .container -->
            </div> <!-- .page-content -->
        </div> <!-- .wrapper -->

        {{-- Scripts --}}
        <script src="{{ asset('admin/assets/js/vendor.js') }}"></script>
        <script src="{{ asset('admin/assets/js/app.js') }}"></script>

        {{-- Script xem trước hình ảnh --}}
        <script>
            document.getElementById('product-images').addEventListener('change', function(event) {
                const previewContainer = document.getElementById('image-preview');
                previewContainer.innerHTML = ''; // Xóa các hình ảnh đã xem trước cũ

                const files = event.target.files;

                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('rounded', 'border');
                            img.style.width = '100px';
                            img.style.height = '100px';
                            img.style.objectFit = 'cover';
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            // Script thêm biến thể động
            const variantsContainer = document.getElementById('variants-container');
            const addVariantBtn = document.getElementById('add-variant-btn');

            function createVariantRow(index = null) {
                // index: nếu cần, có thể dùng để đặt tên input dạng variants[index][field]
                const div = document.createElement('div');
                div.className = 'row align-items-end mb-2 variant-row';
                div.innerHTML = `
                    <div class="col-md-3">
                        <input type="text" name="variants[attribute][]" class="form-control" placeholder="Tên thuộc tính (VD: Màu, Size)" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="variants[value][]" class="form-control" placeholder="Giá trị (VD: Đỏ, L, XL)" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="variants[price][]" class="form-control" placeholder="Giá riêng (VND)">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="variants[stock][]" class="form-control" placeholder="Tồn kho">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-variant-btn">Xóa</button>
                    </div>
                `;
                return div;
            }

            addVariantBtn.addEventListener('click', function() {
                const row = createVariantRow();
                variantsContainer.appendChild(row);
            });

            // Xóa biến thể
            variantsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variant-btn')) {
                    e.target.closest('.variant-row').remove();
                }
            });
        </script>

    </body>
@endsection
