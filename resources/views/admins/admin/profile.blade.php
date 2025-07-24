@extends('admins.layouts.default')

@section('content')
<div class="wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Cập nhật thông tin cá nhân</h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 text-center">
                                    @if($admin->avatar)
                                        <img src="{{ asset('storage/' . $admin->avatar) }}" alt="Avatar" class="rounded-circle mb-2" width="100" height="100">
                                    @else
                                        <img src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}" alt="Avatar" class="rounded-circle mb-2" width="100" height="100">
                                    @endif
                                    <input type="file" name="avatar" class="form-control mt-2">
                                    @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $admin->name) }}">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $admin->email) }}">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $admin->phone) }}">
                                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $admin->address) }}">
                                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 