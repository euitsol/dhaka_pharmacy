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

        if($request->is('api/*')) {
            abort(sendResponse(false, 'Unauthorized', null, 403));
        }

        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
