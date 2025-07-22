<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role && $user->role->role_name === 'admin') {
                return redirect()->route('admin');
            }

            if ($user->role && $user->role->role_name === 'user') {
                return redirect()->route('client.home');
            }

            // fallback nếu không biết role
            return redirect('login');
        }

        return $next($request);
    }
}
