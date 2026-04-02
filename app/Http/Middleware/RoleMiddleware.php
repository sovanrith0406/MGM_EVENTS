<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Usage in routes:
     *   ->middleware('role:admin')
     *   ->middleware('role:admin,supplier')  ← OR logic
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $userRole = strtolower($user->role->role_name ?? '');

        foreach ($roles as $role) {
            if ($userRole === strtolower(trim($role))) {
                return $next($request);
            }
        }
        

        abort(403, 'You do not have permission to access this page.');
    }
    
}