@extends('admins.layouts.default')

@section('content')

<body>
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">

                    {{-- Left Column --}}
                    <div class="col-xl-3 col-lg-4">
                        <div class="card">
                            {{-- Preview Uploaded Images --}}
                            <div class="card-body">
                                <label class="form-label">Ảnh hiện tại</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($product->images as $image)
                                        <div class="position-relative me-2 mb-2">
                                            <img src="{{ asset('storage/' . $image->path) }}"
                                                class="rounded border" style="width: 100px; height: 100px; object-fit: cover;">
                                            
                                            {{-- Form xoá ảnh --}}
                                            <form action="{{ route('products.images.destroy', $image->id) }}"
                                                method="POST"
                                                style="position: absolute; top: 0; right: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger p-1"
                                                    onclick="return confirm('Xoá ảnh này?')">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>

                                            {{-- Chọn ảnh nổi bật --}}
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="radio" name="featured_image"
                                                    value="{{ $image->id }}"
                                                    form="product-form"
                                                    {{ $image->is_featured ? 'checked' : '' }}>
                                                <label class="form-check-label">Nổi bật</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <hr>

                                {{-- Preview ảnh mới chọn --}}
                                <label class="form-label">Ảnh mới (nếu có)</label>
                                <div id="image-preview" class="d-flex flex-wrap gap-2"></div>

                                <label for="product-images" class="btn btn-outline-primary w-100 mt-3">Chọn ảnh mới</label>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="card-footer bg-light-subtle">
                                <div class="row g-2">
                                    <div class="col-lg-6">
                                        <button type="submit" form="product-form"
                                            class="btn btn-outline-secondary w-100">Cập nhật</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="{{ route('products.index') }}"
                                            class="btn btn-primary w-100">Huỷ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="col-xl-9 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Chỉnh sửa sản phẩm</h4>
                            </div>
                            <div class="card-body">
                                <form id="product-form"
                                    action="{{ route('products.update', $product->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Tên sản phẩm --}}
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="product-name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                                <input type="text" id="product-name" name="name"
                                                    class="form-control"
                                                    value="{{ old('name', $product->name) }}">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Danh mục --}}
                                        <div class="col-lg-6">
                                            <label for="product-categories" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                            <select class="form-control" id="product-categories" name="category_id">
                                                <option value="">-- Chọn danh mục --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                                        {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
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
                                                <textarea class="form-control bg-light-subtle" id="description"
                                                    name="description" rows="7">{{ old('description', $product->description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Giá --}}
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="product-price" class="form-label">Giá <span class="text-danger">*</span></label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text fs-20"><i class='bx bx-dollar'></i></span>
                                                <input type="number" id="product-price" name="base_price"
                                                    class="form-control"
                                                    value="{{ old('base_price', $product->base_price) }}">
                                                @error('base_price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Biến thể sản phẩm --}}
                                    {{-- <div class="row mt-4">
                                        <div class="col-lg-12">
                                            <label class="form-label">Biến thể sản phẩm</label>
                                            <div id="variants-container">
                                                @if($product->variants && count($product->variants))
                                                    @foreach($product->variants as $i => $variant)
                                                        <div class="row align-items-end mb-2 variant-row">
                                                            <div class="col-md-3">
                                                                <input type="text" name="variants[attribute][]" class="form-control" placeholder="Tên thuộc tính" value="{{ ($variant->attributes && $variant->attributes->first()) ? $variant->attributes->first()->name : '' }}" required readonly>
                                                                <small class="text-muted">{{ ($variant->attributes && $variant->attributes->first()) ? $variant->attributes->first()->name : '' }}</small>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" name="variants[value][]" class="form-control" placeholder="Giá trị" value="{{ ($variant->attributeValues && $variant->attributeValues->first()) ? $variant->attributeValues->first()->value : '' }}" required>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="number" name="variants[price][]" class="form-control" placeholder="Giá riêng (VND)" value="{{ $variant->price }}">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="number" name="variants[stock][]" class="form-control" placeholder="Tồn kho" value="{{ $variant->stock_quantity }}">
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center gap-2">
                                                                <span class="badge {{ $variant->status == 'active' ? 'bg-success' : 'bg-secondary' }}">{{ $variant->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</span>
                                                                <button type="button" class="btn btn-outline-{{ $variant->status == 'active' ? 'secondary' : 'success' }} btn-sm toggle-variant-status-btn" data-variant-id="{{ $variant->id }}">
                                                                    {{ $variant->status == 'active' ? 'Đổi trạng thái' : 'Kích hoạt' }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-outline-primary mt-2" id="add-variant-btn">Thêm biến thể</button>
                                        </div>
                                    </div> --}}
                                    {{-- Input ẩn để upload ảnh mới --}}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3 d-none">
                                                <input type="file" name="images[]" id="product-images"
                                                    class="form-control" multiple accept="image/*">
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
    <script>
        // Tự động cập nhật hình ảnh xem trước khi chọn ảnh mới
        document.getElementById('product-images').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = '';
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

            // Đổi trạng thái hoạt động/không hoạt động cho biến thể
            document.querySelectorAll('.toggle-variant-status-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var variantId = btn.getAttribute('data-variant-id');
                    var token = document.querySelector('input[name="_token"]').value;
                    fetch('/admin/variants/' + variantId + '/toggle-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Đổi màu badge và nút
                            const badge = btn.parentElement.querySelector('.badge');
                            if (data.status === 'active') {
                                badge.classList.remove('bg-secondary');
                                badge.classList.add('bg-success');
                                badge.textContent = 'Hoạt động';
                                btn.classList.remove('btn-outline-success');
                                btn.classList.add('btn-outline-secondary');
                                btn.textContent = 'Đổi trạng thái';
                            } else {
                                badge.classList.remove('bg-success');
                                badge.classList.add('bg-secondary');
                                badge.textContent = 'Không hoạt động';
                                btn.classList.remove('btn-outline-secondary');
                                btn.classList.add('btn-outline-success');
                                btn.textContent = 'Kích hoạt';
                            }
                        } else {
                            alert('Đổi trạng thái thất bại!');
                        }
                    })
                    .catch(() => alert('Có lỗi xảy ra!'));
                });
            });
    </script>

</body>

@endsection
