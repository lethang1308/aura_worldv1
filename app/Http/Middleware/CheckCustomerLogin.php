<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->withErrors('Bạn cần đăng nhập để truy cập.');
        }

        $user = Auth::user();

        // Kiểm tra nếu không có role liên kết
        if (!$user->role) {
            return redirect()->route('login')->withErrors('Bạn không có quyền truy cập.');
        }

        // Chỉ cho phép customer (role_id = 2) truy cập
        if ($user->role_id == 2) {
            return $next($request);
        }

        // Nếu là admin hoặc shipper, redirect về trang chủ
        if ($user->role_id == 1) {
            return redirect()->route('admin');
        }

        if ($user->role_id == 3) {
            return redirect()->route('shipper.home');
        }

        return redirect()->route('login')->withErrors('Bạn không có quyền truy cập.');
    }
}
