<?php

namespace App\Http\Middleware;

use Closure;

class SecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return ($request->user()->roles != '2') ? redirect()->route('home') : $next($request);
    }
}
