@extends('admins.layouts.default')

@section('content')
<body>
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    {{-- Left Column: Preview + Buttons --}}
                    <div class="col-xl-3 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <label class="form-label">Xem trước logo</label>
                                <div id="logo-preview" class="d-flex flex-wrap gap-2">
                                    @if($brand->logo)
                                        <img src="{{ asset($brand->logo) }}" alt="Logo" class="rounded border" style="width:100px;height:100px;object-fit:cover;">
                                    @endif
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="brand-logo" class="btn btn-outline-primary w-100">Chọn logo</label>
                                </div>
                            </div>
                            <div class="card-footer bg-light-subtle">
                                <div class="row g-2">
                                    <div class="col-lg-6">
                                        <button type="submit" form="brand-form" class="btn btn-outline-secondary w-100">Cập nhật thương hiệu</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="{{ route('brands.index') }}" class="btn btn-primary w-100">Huỷ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Right Column: Form --}}
                    <div class="col-xl-9 col-lg-8 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Chỉnh sửa thông tin thương hiệu</h4>
                            </div>
                            <div class="card-body">
                                <form id="brand-form" action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Tên thương hiệu</label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên thương hiệu" value="{{ old('name', $brand->name) }}" required>
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Trạng thái</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="active" {{ old('status', $brand->status) == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                                                    <option value="inactive" {{ old('status', $brand->status) == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                                                </select>
                                                @error('status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Mô tả</label>
                                                <textarea class="form-control bg-light-subtle" id="description" name="description" rows="5" placeholder="Mô tả">{{ old('description', $brand->description) }}</textarea>
                                                @error('description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3 d-none">
                                                <input type="file" name="logo_file" id="brand-logo" class="form-control" accept="image/*">
                                                @error('logo_file')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <input type="hidden" name="logo" id="logo-url" value="{{ old('logo', $brand->logo) }}">
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
    <script>
        document.getElementById('brand-logo').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('logo-preview');
            previewContainer.innerHTML = '';
            const files = event.target.files;
            if (files.length > 0 && files[0].type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('rounded', 'border');
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    previewContainer.appendChild(img);
                    document.getElementById('logo-url').value = e.target.result;
                };
                reader.readAsDataURL(files[0]);
            } else {
                // Nếu không chọn file mới, giữ lại logo cũ
                previewContainer.innerHTML = `<img src='{{ asset($brand->logo) }}' alt='Logo' class='rounded border' style='width:100px;height:100px;object-fit:cover;'>`;
                document.getElementById('logo-url').value = "{{ asset($brand->logo) }}";
            }
        });
    </script>
</body>
@endsection 