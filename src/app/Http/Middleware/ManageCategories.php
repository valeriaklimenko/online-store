<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManageCategories
{
    /**
     * Only admins can manages categories
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasRole(Roles::ADMIN->value)) {
            abort(403, 'Only administrators can manage categories.');
        }

        return $next($request);
    }
}
