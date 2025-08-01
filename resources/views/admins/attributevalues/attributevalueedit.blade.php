@extends('admins.layouts.default')

@section('content')
<div class="wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Chỉnh sửa giá trị thuộc tính</h4>
                            <a href="{{ route('attributeValues.list') }}" class="btn btn-outline-primary btn-sm">Quay lại danh sách</a>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('attributeValues.update', $value->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Thuộc tính</label>
                                    <select name="attribute_id" class="form-control" required>
                                        @foreach($attributes as $attr)
                                            <option value="{{ $attr->id }}"
                                                {{ $value->attribute_id == $attr->id ? 'selected' : '' }}>
                                                {{ $attr->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Giá trị</label>
                                    <input type="text" name="value" class="form-control"
                                        value="{{ old('value', $value->value) }}" required>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success">Cập nhật</button>
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
