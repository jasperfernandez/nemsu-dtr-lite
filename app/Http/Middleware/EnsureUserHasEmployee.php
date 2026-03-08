<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasEmployee
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->employee) {
            if (! $request->routeIs('employee.link.*')) {
                return redirect()->route('employee.link.show');
            }
        }

        return $next($request);
    }
}

