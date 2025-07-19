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

                                <label for="product-images" class="btn btn-outline-primary w-100 mt-3">
                                    Chọn ảnh mới
                                </label>
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
                                                <label for="product-name" class="form-label">Tên sản phẩm</label>
                                                <input type="text" id="product-name" name="name"
                                                    class="form-control"
                                                    value="{{ old('name', $product->name) }}" required>
                                            </div>
                                        </div>

                                        {{-- Danh mục --}}
                                        <div class="col-lg-6">
                                            <label for="product-categories" class="form-label">Danh mục</label>
                                            <select class="form-control" id="product-categories" name="category_id"
                                                required>
                                                <option value="">-- Chọn danh mục --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
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
                                            <label for="product-price" class="form-label">Giá</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text fs-20"><i class='bx bx-dollar'></i></span>
                                                <input type="number" id="product-price" name="base_price"
                                                    class="form-control"
                                                    value="{{ old('base_price', $product->base_price) }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

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
    </script>

</body>

@endsection
