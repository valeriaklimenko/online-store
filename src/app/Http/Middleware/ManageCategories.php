<?php

namespace App\Http\Middleware;

use App\Enums\FlashMessage;
use App\Enums\RoleSystem\Roles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManageCategories
{
    /**
     * Only admins can manage categories
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasRole(Roles::ADMIN->value)) {
            abort(403, FlashMessage::ACCESS_DENIED->value);
        }

        return $next($request);
    }
}
