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

                                    <!-- Attribute Values -->
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label text-dark">Giá trị thuộc tính</label>
                                            <div id="attribute-values-list">
                                                @if(isset($attributeValues) && count($attributeValues) > 0)
                                                    @foreach($attributeValues as $key => $value)
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="values[{{ $value->id }}]" class="form-control" value="{{ old('values.' . $value->id, $value->value) }}" required>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeValueRow(this)">Xóa</button>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <!-- Thêm giá trị mới -->
                                            <div id="new-values-list"></div>
                                            <button type="button" class="btn btn-outline-success btn-sm mt-2" onclick="addValueRow()">Thêm giá trị</button>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Cập nhật thuộc tính</button>
                                    </div>

                                    <script>
                                        function addValueRow() {
                                            var newId = Date.now();
                                            var html = `<div class=\"input-group mb-2\">`
                                                + `<input type=\"text\" name=\"new_values[]\" class=\"form-control\" required>`
                                                + `<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"removeValueRow(this)\">Xóa</button>`
                                                + `</div>`;
                                            document.getElementById('new-values-list').insertAdjacentHTML('beforeend', html);
                                        }
                                        function removeValueRow(btn) {
                                            btn.parentElement.remove();
                                        }
                                    </script>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
