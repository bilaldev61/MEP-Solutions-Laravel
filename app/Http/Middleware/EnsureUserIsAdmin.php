<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Only users with the 'admin' role may pass. Managers get a 403.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'This area is restricted to administrators.');
        }

        return $next($request);
    }
}
