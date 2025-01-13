<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EnsureBuyerEmailIsVerified
{
    protected $allowedRoutes = [
        'verification.notice',
        'verification.verify',
        'home',
        'login',
        'register',
        'password.request',
        'password.reset',
        'product-categories',
        'all-products',
        'product-details',
        'seller.page',
        'blog',
        'blog.post',
        'discounts.calendar'
    ];

    public function handle($request, Closure $next)
    {
        if (!Auth::guard('buyer')->check()) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            if ($request->routeIs($this->allowedRoutes)) {
                return $next($request);
            }

            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route('verification.notice');
        }

        return $next($request);
    }
}
