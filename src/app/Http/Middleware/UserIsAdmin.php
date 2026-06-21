<?php

namespace App\Http\Middleware;

use App\Enums\RoleSystem\Roles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserIsAdmin
{

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasRole(Roles::ADMIN->value)) {
            abort(403, Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
