<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class CheckPermissionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = Route::currentRouteName();

        // Specify the route name prefixes that require permission checks
        // $allowedPrefixes = []; //for testing purpose
        $allowedPrefixes = get_permission_routes();

        $shouldCheckPermission = false;
        foreach ($allowedPrefixes as $prefix) {
            if (str_starts_with($routeName, $prefix)) {
                $shouldCheckPermission = true;
                break;
            }
        }

        if ($shouldCheckPermission) {
            $routeParts = explode('.', $routeName);
            $lastRoutePart = end($routeParts);

            if (!auth()->user()->can($lastRoutePart)) {
                abort(403, 'Unauthorized');
            }
        }

        return $next($request);
    }
}
