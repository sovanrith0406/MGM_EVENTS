<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Redirect unauthenticated users to the login page.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Return null for API/AJAX requests (returns 401 JSON instead)
        if ($request->expectsJson()) {
            return null;
        }

        return route('login');
    }
}