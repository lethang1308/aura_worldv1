@extends('admins.layouts.default')

@section('content')
<body>
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    {{-- Cột bên trái: Nút thao tác --}}
                    <div class="col-xl-3 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <label class="form-label">Thao tác</label>
                                <div class="mb-3 mt-3">
                                    <button type="submit" form="coupon-form" class="btn btn-outline-secondary w-100 mb-2">Lưu phiếu giảm giá</button>
                                    <a href="{{ route('coupons.index') }}" class="btn btn-primary w-100">Quay lại danh sách</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Cột bên phải: Biểu mẫu --}}
                    <div class="col-xl-9 col-lg-8 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Thông tin phiếu giảm giá</h4>
                            </div>
                            <div class="card-body">
                                <form id="coupon-form" action="{{ route('coupons.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="code" class="form-label">Mã giảm giá</label>
                                                <input type="text" id="code" name="code" class="form-control" placeholder="Nhập mã giảm giá" value="{{ old('code') }}" required>
                                                @error('code')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="type" class="form-label">Loại giảm giá</label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="fixed" {{ old('type')=='fixed'?'selected':'' }}>Cố định</option>
                                                <option value="percent" {{ old('type')=='percent'?'selected':'' }}>Phần trăm</option>
                                            </select>
                                            @error('type')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="value" class="form-label">Giá trị giảm</label>
                                                <input type="number" id="value" name="value" class="form-control" value="{{ old('value') }}" required min="0">
                                                @error('value')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="min_order_value" class="form-label">Đơn hàng tối thiểu</label>
                                            <input type="number" id="min_order_value" name="min_order_value" class="form-control" value="{{ old('min_order_value') }}" min="0">
                                            @error('min_order_value')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="max_discount" class="form-label">Giảm tối đa (nếu là %)</label>
                                            <input type="number" id="max_discount" name="max_discount" class="form-control" value="{{ old('max_discount') }}" min="0">
                                            @error('max_discount')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="usage_limit" class="form-label">Giới hạn lượt sử dụng</label>
                                            <input type="number" id="usage_limit" name="usage_limit" class="form-control" value="{{ old('usage_limit') }}" min="1">
                                            @error('usage_limit')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                            @error('start_date')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                            @error('end_date')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="status" class="form-label">Trạng thái</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="active" {{ old('status')=='active'?'selected':'' }}>Kích hoạt</option>
                                                <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Ẩn</option>
                                            </select>
                                            @error('status')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Mô tả</label>
                                                <textarea class="form-control bg-light-subtle" id="description" name="description" rows="5" placeholder="Nhập mô tả ngắn gọn về phiếu giảm giá">{{ old('description') }}</textarea>
                                                @error('description')<div class="text-danger">{{ $message }}</div>@enderror
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
</body>
@endsection