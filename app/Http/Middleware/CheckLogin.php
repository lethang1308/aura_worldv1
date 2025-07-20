<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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

        if ($user->isRoleUser()) {
            return redirect()->route('clients.home');
        }

        if ($user->isRoleAdmin()) {
            return $next($request);
        }

        return redirect()->route('login')->withErrors('Bạn không đủ quyền truy cập.');
    }
}
