@extends('admins.layouts.default')

@section('content')

<div class="page-content">
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title mb-0">Chỉnh sửa danh mục</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row gy-4">

                                {{-- Tên danh mục --}}
                                <div class="col-lg-6">
                                    <label for="category_name" class="form-label">Tên danh mục</label>
                                    <input type="text" class="form-control" name="category_name" id="category_name"
                                           value="{{ old('category_name', $category->category_name) }}" required>
                                </div>

                                {{-- Danh mục cha --}}
                                <div class="col-lg-6">
                                    <label for="parent_category_id" class="form-label">Danh mục cha</label>
                                    <select name="parent_category_id" id="parent_category_id" class="form-select">
                                        <option value="">-- Không chọn --</option>
                                        @foreach ($categories as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ old('parent_category_id', $category->parent_category_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Mô tả --}}
                                <div class="col-lg-12">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"
                                              placeholder="Nhập mô tả">{{ old('description', $category->description) }}</textarea>
                                </div>

                                {{-- Trạng thái --}}
                                <div class="col-lg-6">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="deactive" {{ old('status', $category->status) == 'deactive' ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                </div>

                            </div>

                            {{-- Nút hành động --}}
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
