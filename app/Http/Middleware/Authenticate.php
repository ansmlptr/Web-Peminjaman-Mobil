<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Check if the request is for customer routes
        if ($request->is('user/*') || $request->is('login') || $request->is('register')) {
            return route('user.login');
        }

        // Default to admin login
        return route('admin.login');
    }
}
