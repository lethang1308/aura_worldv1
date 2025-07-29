@extends('admins.layouts.default')

@section('content')
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <h4 class="card-title">Chỉnh sửa thuộc tính</h4>
                                <a href="{{ route('attributes.index') }}" class="btn btn-outline-primary btn-sm">Quay lại danh sách</a>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <!-- Attribute Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="attribute-name" class="form-label text-dark">Tên thuộc tính</label>
                                            <input type="text" name="name" id="attribute-name" class="form-control"
                                                value="{{ old('name', $attribute->name) }}"
                                                placeholder="Nhập tên thuộc tính" required>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Cập nhật thuộc tính</button>
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
