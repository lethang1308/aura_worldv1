@extends('admins.layouts.default')

@section('content')
<div class="wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Tạo danh mục mới</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf

                                <!-- Tên danh mục -->
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Tên danh mục</label>
                                    <input type="text" name="category_name" class="form-control" placeholder="Nhập tên danh mục" required>
                                </div>

                                <!-- Danh mục cha -->
                                <div class="mb-3">
                                    <label for="parent_category_id" class="form-label">Danh mục cha</label>
                                    <select name="parent_category_id" class="form-select">
                                        <option value="">-- Không có (Danh mục gốc) --</option>
                                        @foreach ($categories as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Mô tả -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea name="description" class="form-control" rows="4" placeholder="Nhập mô tả danh mục"></textarea>
                                </div>

                                <!-- Trạng thái -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select" required>
                                        <option value="1">Đang hoạt động</option>
                                        <option value="0">Ngừng hoạt động</option>
                                    </select>
                                </div>

                                <!-- Submit -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Tạo danh mục</button>
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary ms-2">Quay lại</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
