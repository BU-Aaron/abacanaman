<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Check if the request is for an admin route
        if ($request->is('admin/*') || $request->is('filament/*')) {
            return Filament::getLoginUrl(); // Typically /admin/login
        }

        // For all other routes, redirect to the storefront login
        return route('login'); // Ensure this points to /login
    }
}
