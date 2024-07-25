<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class isBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $allowed = ['contact', 'contact.email', 'user.blocked', 'logout'];
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $route = Route::currentRouteName();

        // If the user is blocked and tries to access a forbidden route
        if($user && $user->hasRole('blocked') && !in_array($route, $this->allowed))
            return redirect()->route('user.blocked');
        return $next($request); // TODO
    }
}
