<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckUserQuartier
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
        if (Auth::user()->quartiers->count() != 0) {
            return $next($request);
        }
        Auth::logout();
        return Redirect::to('login')->withSuccess('Erreur, vous n\'avez aucun quartier à gérer, veuillez contacter un administrateur !');
    }
}
