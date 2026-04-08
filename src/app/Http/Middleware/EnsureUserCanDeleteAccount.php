<?php

namespace App\Http\Middleware;

use App\Enums\RoleSystem\Roles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanDeleteAccount
{
    /**
     * Only regular users can delete their own account.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        $hasAdminRole = $user->hasRole(Roles::ADMIN->value);
        $hasManagerRole = $user->hasRole(Roles::MANAGER->value);

        if ($hasAdminRole || $hasManagerRole) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
