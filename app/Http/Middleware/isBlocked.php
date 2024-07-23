<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $route = Route::currentRouteName();

        // If the user is blocked and tries to access a forbidden route
        if($user && user->hasRole('blocked') && !in_array($route, $this->allowed()))
            return redirect()->route(user.blocked);
        return $next($request);
    }
}
