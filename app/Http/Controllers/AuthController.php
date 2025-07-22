<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Faker\Factory as Faker;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'nullable|string',
            'address'  => 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'address'  => $request->address,
            'role_id'  => 2, // mặc định người dùng
            'is_active' => 1,
        ]);

        Auth::login($user);
        return redirect()->route('admin');
    }

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Lấy user theo email
        $user = User::where('email', $credentials['email'])->first();

        // Kiểm tra user tồn tại và active
        if (!$user || !$user->is_active) {
            return back()->withErrors([
                'email' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không đúng.',
        ]);
    }

    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        session_start();
        session_unset();
        session_destroy();
        return redirect()->route('login'); // chuyển về trang login sau khi logout
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $faker = Faker::create();
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Tìm user theo email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Nếu chưa tồn tại thì tạo mới
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(6)),
                    'phone'     => $faker->phoneNumber(),
                    'address'   => $faker->address(),
                    'role_id'   => 2, 
                    'is_active' => 1,
                ]);
            } else {
                // Nếu tài khoản bị khóa thì không cho đăng nhập
                if (!$user->is_active) {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.',
                    ]);
                }
            }

            Auth::login($user);
            return redirect()->route('client.home');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Đăng nhập bằng Google thất bại!',
            ]);
        }
    }

    // Hiển thị form đổi mật khẩu
    public function showChangePasswordForm()
    {
        return view('auth.passwords.change');
    }

    // Xử lý đổi mật khẩu
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
