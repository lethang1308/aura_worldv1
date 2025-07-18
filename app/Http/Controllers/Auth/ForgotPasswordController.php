<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    // Xử lý gửi email reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $token = Str::random(64);
        $email = $request->email;

        // Xóa token cũ (nếu có)
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        // Lưu token mới
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Gửi email
        $resetLink = url('/password/reset/' . $token . '?email=' . urlencode($email));
        Mail::raw('Click vào link sau để đặt lại mật khẩu: ' . $resetLink, function ($message) use ($email) {
            $message->to($email)->subject('Đặt lại mật khẩu');
        });

        return back()->with('status', 'Đã gửi email đặt lại mật khẩu!');
    }

    // Hiển thị form đặt lại mật khẩu
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.passwords.reset', compact('token', 'email'));
    }

    // Xử lý đặt lại mật khẩu
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Token không hợp lệ hoặc đã hết hạn.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Xóa token sau khi dùng
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Đặt lại mật khẩu thành công!');
    }
} 