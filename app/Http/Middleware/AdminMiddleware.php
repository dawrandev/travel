<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() !== 1) {
            return redirect()->route('login')->with('error', 'У вас нет доступа к админ-панели');
        }

        return $next($request);
    }
}
