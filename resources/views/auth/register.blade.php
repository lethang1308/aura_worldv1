<!DOCTYPE html>
<html lang="vi" class="h-100" data-bs-theme="light" data-topbar-color="light" data-menu-color="dark"
    data-menu-size="sm-hover-active">

<head>
    <meta charset="utf-8">
    <title>Đăng Ký | Aura World - Bảng Điều Khiển Quản Trị</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mẫu bảng điều khiển quản trị cao cấp, phản hồi đầy đủ">
    <meta name="author" content="Techzaa">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">
    <link href="{{ asset('admin/assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>
</head>

<body class="h-100">
    <div class="d-flex flex-column h-100 p-3">
        <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">
                <div class="col-xxl-7">
                    <div class="row justify-content-center h-100">
                        <div class="col-lg-6 py-lg-5">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="auth-logo mb-4">
                                    <a href="index-2.html" class="logo-dark">
                                        <img src="{{ asset('admin/assets/images/logo-dark.png') }}" height="24" alt="logo dark">
                                    </a>
                                    <a href="index-2.html" class="logo-light">
                                        <img src="{{ asset('admin/assets/images/logo-light.png') }}" height="24" alt="logo light">
                                    </a>
                                </div>

                                <h2 class="fw-bold fs-24">Đăng Ký</h2>
                                <p class="text-muted mt-1 mb-4">Lần đầu sử dụng? Đăng ký ngay! Chỉ mất một phút.</p>

                                <div>
                                    {{-- Hiển thị lỗi --}}
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                    @endif

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        {{-- Họ tên --}}
                                        <div class="mb-3">
                                            <label class="form-label" for="example-name">Họ và tên</label>
                                            <input type="text" name="name" id="example-name" class="form-control"
                                                placeholder="Nhập họ tên" required value="{{ old('name') }}">
                                            @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Email --}}
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email">Email</label>
                                            <input type="email" name="email" id="example-email" class="form-control"
                                                placeholder="Nhập email" required value="{{ old('email') }}">
                                            @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Số điện thoại --}}
                                        <div class="mb-3">
                                            <label class="form-label" for="example-phone">Số điện thoại</label>
                                            <input type="tel" name="phone" id="example-phone" class="form-control"
                                                placeholder="Nhập số điện thoại" required value="{{ old('phone') }}">
                                            @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Địa chỉ --}}
                                        <div class="mb-3">
                                            <label class="form-label" for="example-address">Địa chỉ</label>
                                            <input type="text" name="address" id="example-address" class="form-control"
                                                placeholder="Nhập địa chỉ" required value="{{ old('address') }}">
                                            @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Mật khẩu --}}
                                        <div class="mb-3">
                                            <label class="form-label" for="example-password">Mật khẩu</label>
                                            <input type="password" name="password" id="example-password"
                                                class="form-control" placeholder="Nhập mật khẩu" required>
                                            @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Xác nhận mật khẩu --}}
                                        <div class="mb-3">
                                            <label class="form-label" for="example-password-confirm">Xác nhận mật khẩu</label>
                                            <input type="password" name="password_confirmation"
                                                id="example-password-confirm" class="form-control"
                                                placeholder="Nhập lại mật khẩu" required>
                                        </div>

                                        {{-- Đồng ý điều khoản --}}
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signin" required>
                                                <label class="form-check-label" for="checkbox-signin">
                                                    Tôi đồng ý với các điều khoản và điều kiện
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Nút đăng ký --}}
                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-soft-primary" type="submit">Đăng Ký</button>
                                        </div>
                                    </form>
                                </div>

                                <p class="mt-auto text-danger text-center">
                                    Đã có tài khoản?
                                    <a href="{{ asset('login')}}" class="text-dark fw-bold ms-1">Đăng Nhập</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-5 d-none d-xxl-flex">
                    <div class="card h-100 mb-0 overflow-hidden">
                        <div class="d-flex flex-column h-100">
                            <img src="{{ asset('admin/assets/images/small/img-10.jpg') }}" alt="" class="w-100 h-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/assets/js/vendor.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
</body>

</html>