<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToProfileByRole
{
    /**
     * Handle an incoming request.
     *
     * Redirects authenticated users to their appropriate profile based on their role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        if ($request->routeIs('admin.profile') || $request->routeIs('manager.profile') || $request->routeIs('user.profile')) {
            return $next($request);
        }

        if ($request->routeIs('profile')) {
            if ($user->hasRole(Roles::ADMIN->value)) {
                return redirect()->route('admin.profile');
            }

            if ($user->hasRole(Roles::MANAGER->value)) {
                return redirect()->route('manager.profile');
            }

            return $next($request);
        }

        return $next($request);
    }
}
