<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateBuyer
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('buyer')->check()) {
            return redirect('/login'); // Redirect to storefront login
        }

        return $next($request);
    }
}
