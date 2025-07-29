@extends('admins.layouts.default')

@section('content')
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <h4 class="card-title">Tạo thuộc tính mới</h4>
                                <a href="{{ route('attributes.index') }}" class="btn btn-outline-primary btn-sm">Quay lại danh sách</a>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('attributes.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <!-- Attribute Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="attribute-name" class="form-label text-dark">Tên thuộc tính</label>
                                            <input type="text" name="name" id="attribute-name" class="form-control" placeholder="Nhập tên thuộc tính" required>
                                        </div>
                                    </div>

                                    <!-- Attribute Values -->
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label class="form-label text-dark">Giá trị thuộc tính</label>
                                            <div id="attribute-values-list">
                                                <div class="input-group mb-2">
                                                    <input type="text" name="values[]" class="form-control" placeholder="Nhập giá trị" required>
                                                    <button type="button" class="btn btn-danger remove-value" style="display:none;">X</button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm" id="add-value">+ Thêm giá trị</button>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Lưu thuộc tính</button>
                                    </div>
                                </form>
                            </div>

                            <script>
                                document.getElementById('add-value').onclick = function() {
                                    let list = document.getElementById('attribute-values-list');
                                    let item = document.createElement('div');
                                    item.className = 'input-group mb-2';
                                    item.innerHTML = `
                                        <input type="text" name="values[]" class="form-control" placeholder="Nhập giá trị" required>
                                        <button type="button" class="btn btn-danger remove-value">X</button>
                                    `;
                                    list.appendChild(item);
                                };

                                document.addEventListener('click', function(e) {
                                    if (e.target && e.target.classList.contains('remove-value')) {
                                        e.target.parentElement.remove();
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
