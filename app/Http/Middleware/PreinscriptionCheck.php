<?php

namespace App\Http\Middleware;

use Closure;

class PreinscriptionCheck
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
        if (Auth::user()->role->role != 'preinscription') {
        return redirect(route('home'));
        }
        return $next($request);
    }
}
