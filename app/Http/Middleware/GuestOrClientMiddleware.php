<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestOrClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role !== 'user') {
            // abort(403);
            return redirect()->route('dashboard')->withErrors(['error' => 'Acesso negado. Apenas administradores podem acessar esta página!']);
        }

        return $next($request);
    }
}
