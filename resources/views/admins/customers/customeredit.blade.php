@extends('admins.layouts.default')

@section('content')

<div class="page-content">
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title mb-0">Chỉnh sửa khách hàng</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row gy-4">

                                {{-- Tên khách hàng --}}
                                <div class="col-lg-6">
                                    <label for="name" class="form-label">Tên khách hàng</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ $customer->name }}" readonly>
                                </div>

                                {{-- Email --}}
                                <div class="col-lg-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           value="{{ $customer->email }}" readonly>
                                </div>

                                {{-- Số điện thoại --}}
                                <div class="col-lg-6">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                           value="{{ $customer->phone }}" readonly>
                                </div>

                                {{-- Địa chỉ --}}
                                <div class="col-lg-6">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                           value="{{ $customer->address }}" readonly>
                                </div>

                                {{-- Trạng thái --}}
                                <div class="col-lg-6">
                                    <label for="is_active" class="form-label">Trạng thái</label>
                                    <select name="is_active" id="is_active" class="form-select" required>
                                        <option value="1" {{ old('is_active', $customer->is_active) == 1 ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ old('is_active', $customer->is_active) == 0 ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                </div>

                            </div>

                            {{-- Nút hành động --}}
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
