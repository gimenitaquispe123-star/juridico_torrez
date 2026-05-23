<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || $user->rol !== 'cliente') {
            // Redirige al login o al home
            return redirect('/')->with('error', 'No tienes acceso a esta sección.');
        }

        return $next($request);
    }
}
