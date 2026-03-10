<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  public function handle($request, Closure $next)
{
    // Logic: Is the user logged in? AND Is the user an admin?
    if (auth()->check() && auth()->user()->is_admin == 1) {
        return $next($request); // Let them pass
    }

    // If not admin, send them to the home page
    return redirect('/')->with('error', 'You do not have admin access');
}
}
