<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Mail;
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
                $randomPassword = Str::random(8);
                // Nếu chưa tồn tại thì tạo mới
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make($randomPassword),
                    'phone'     => $faker->phoneNumber(),
                    'address'   => $faker->address(),
                    'role_id'   => 2,
                    'is_active' => 1,
                ]);
                Mail::raw("Xin chào {$user->name},\n\nTài khoản của bạn đã được tạo thành công.\nMật khẩu đăng nhập: {$randomPassword}\n\nVui lòng đổi mật khẩu sau khi đăng nhập.", function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Thông tin tài khoản đăng nhập');
                });
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
}
