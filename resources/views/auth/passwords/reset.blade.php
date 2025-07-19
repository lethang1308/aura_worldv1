<!DOCTYPE html>
<html lang="en" class="h-100" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <title>Reset Password | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template">
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
                                    <a href="index.html" class="logo-dark">
                                        <img src="{{ asset('admin/assets/images/logo-dark.png') }}" height="24"
                                            alt="logo dark">
                                    </a>
                                    <a href="index.html" class="logo-light">
                                        <img src="{{ asset('admin/assets/images/logo-light.png') }}" height="24"
                                            alt="logo light">
                                    </a>
                                </div>

                                <h2 class="fw-bold fs-24">Reset Password</h2>
                                <p class="text-muted mt-1 mb-4">Enter your new password and OTP code to reset your password.</p>

                                {{-- Hiển thị thành công --}}
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                {{-- Hiển thị lỗi --}}
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mb-5">
                                    <form method="POST" action="{{ route('password.handleReset') }}" class="authentication-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="email" value="{{ session('email') }}">
                                        
                                        <div class="mb-3">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="password" name="password" 
                                                placeholder="Enter new password" required>
                                            @error('password')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" 
                                                name="password_confirmation" placeholder="Confirm new password" required>
                                            @error('password_confirmation')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="otp" class="form-label">OTP Code</label>
                                            <input type="text" class="form-control" id="otp" name="otp" 
                                                placeholder="Enter OTP code" required>
                                            @error('otp')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-soft-primary" type="submit">Reset Password</button>
                                        </div>
                                    </form>

                                    <div class="text-center mt-4">
                                        <p class="text-muted">Remember your password? 
                                            <a href="{{ route('login') }}" class="text-dark fw-bold ms-1">Sign In</a>
                                        </p>
                                        <p class="text-muted">Didn't receive OTP? 
                                            <a href="{{ route('password.forgot') }}" class="text-dark fw-bold ms-1">Resend OTP</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-5 d-none d-xxl-flex">
                    <div class="card h-100 mb-0 overflow-hidden">
                        <div class="d-flex flex-column h-100">
                            <img src="{{ asset('admin/assets/images/small/img-10.jpg') }}" alt=""
                                class="w-100 h-100 object-fit-cover">
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