<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch ($guard) {
                case 'admin':
                    $path = 'admin';
                    break;

                case 'user':
                    $path = 'user';
                    break;

                default:
                    $path = 'user';
                    break;
            }

           return redirect()->guest($path);
        }
        
        return $next($request);
    }
}
