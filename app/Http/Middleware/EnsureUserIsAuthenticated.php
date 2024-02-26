<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) { // Si l'utilisateur n'est pas connecté
            return redirect()->route('login'); // Rediriger vers la route de connexion
        }

        return $next($request); // Continuer la requête si l'utilisateur est connecté
    }
}
