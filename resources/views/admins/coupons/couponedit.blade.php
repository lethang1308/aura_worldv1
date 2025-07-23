@extends('admins.layouts.default')

@section('content')
<body>
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    {{-- Left Column: Action Buttons --}}
                    <div class="col-xl-3 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <label class="form-label">Thao tác</label>
                                <div class="mb-3 mt-3">
                                    <button type="submit" form="coupon-form" class="btn btn-outline-secondary w-100 mb-2">Cập nhật phiếu giảm giá</button>
                                    <a href="{{ route('coupons.index') }}" class="btn btn-primary w-100">Quay lại danh sách</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Right Column: Form --}}
                    <div class="col-xl-9 col-lg-8 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Cập nhật phiếu giảm giá</h4>
                            </div>
                            <div class="card-body">
                                <form id="coupon-form" action="{{ route('coupons.update', $coupon->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="code" class="form-label">Coupon Code</label>
                                                <input type="text" id="code" name="code" class="form-control" placeholder="Coupon code" value="{{ old('code', $coupon->code) }}" required>
                                                @error('code')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="type" class="form-label">Type</label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="fixed" {{ old('type', $coupon->type)=='fixed'?'selected':'' }}>Cố định</option>
                                                <option value="percent" {{ old('type', $coupon->type)=='percent'?'selected':'' }}>Phần trăm</option>
                                            </select>
                                            @error('type')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="value" class="form-label">Giá trị giảm</label>
                                                <input type="number" id="value" name="value" class="form-control" value="{{ old('value', $coupon->value) }}" required min="0">
                                                @error('value')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="min_order_value" class="form-label">Đơn hàng tối thiểu</label>
                                            <input type="number" id="min_order_value" name="min_order_value" class="form-control" value="{{ old('min_order_value', $coupon->min_order_value) }}" min="0">
                                            @error('min_order_value')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="max_discount" class="form-label">Giảm tối đa (nếu %)</label>
                                            <input type="number" id="max_discount" name="max_discount" class="form-control" value="{{ old('max_discount', $coupon->max_discount) }}" min="0">
                                            @error('max_discount')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="usage_limit" class="form-label">Giới hạn lượt dùng</label>
                                            <input type="number" id="usage_limit" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1">
                                            @error('usage_limit')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date ? ( $coupon->start_date instanceof \Carbon\Carbon ? $coupon->start_date->format('Y-m-d') : \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') ) : '') }}">
                                            @error('start_date')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $coupon->end_date ? ( $coupon->end_date instanceof \Carbon\Carbon ? $coupon->end_date->format('Y-m-d') : \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d') ) : '') }}">
                                            @error('end_date')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="status" class="form-label">Trạng thái</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="active" {{ old('status', $coupon->status)=='active'?'selected':'' }}>Kích hoạt</option>
                                                <option value="inactive" {{ old('status', $coupon->status)=='inactive'?'selected':'' }}>Ẩn</option>
                                            </select>
                                            @error('status')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Mô tả</label>
                                                <textarea class="form-control bg-light-subtle" id="description" name="description" rows="5" placeholder="Short description about the coupon">{{ old('description', $coupon->description) }}</textarea>
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