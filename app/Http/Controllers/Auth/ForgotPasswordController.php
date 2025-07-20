<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Hiển thị form nhập email để lấy lại mật khẩu
    public function showForgotForm()
    {
        return view('auth.passwords.email');
    }

    public function handleForgotPassword(Request $request)
    {
        $error = [];
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|exists:users,email',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại trong hệ thống',
        ]);

        if ($validatedData) {
            $otp = rand(100000, 999999);
            $expiresAt = now()->addMinutes(10); // OTP sẽ hết hạn sau 10 phút

            OtpCode::updateOrCreate(
                ['email' => $validatedData['email']],
                ['otp' => $otp, 'expires_at' => $expiresAt]
            );

            try {
                Mail::to($validatedData['email'])->queue(new ForgotPassword($otp));
                return redirect()->route('password.reset')->with([
                    'success' => 'Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra email để đặt lại mật khẩu.',
                    'email' => $validatedData['email']
                ]);
            } catch (\Exception $e) {
                $error = ['error' => 'Không thể gửi email. Vui lòng thử lại sau.'];
                return redirect()->route('password.forgot')->withErrors($error)->withInput();
            }
        }
    }
    public function handleResetPassword(Request $request)
    {
        $error = [];
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|exists:users,email',
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'otp.required' => 'Mã OTP không được để trống',
            'otp.digits' => 'Mã OTP phải có 6 chữ số',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);
        $otpCode = OtpCode::where('email', $validatedData['email'])
            ->where('otp', $validatedData['otp'])
            ->where('expires_at', '>', now())
            ->first();
        // dd($otpCode);
        if (!$otpCode) {
            $error = ['error' => 'Mã OTP không hợp lệ hoặc đã hết hạn'];
            return redirect()->route('password.reset')->withErrors($error)->withInput();
        }

        $user = User::where('email', $validatedData['email'])->first();
        if ($user) {
            // dd($validatedData);
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user->update(['password' => $validatedData['password']]);
            // Xóa mã OTP sau khi đặt lại mật khẩu thành công
            $otpCode->delete();
            return redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập.');
        } else {
            $error = ['error' => 'Không tìm thấy người dùng với email này'];
            return redirect()->route('password.reset')->withErrors($error)->withInput();
        }
    }

    public function showResetForm()
    {
        return view('auth.passwords.reset');
    }
}
