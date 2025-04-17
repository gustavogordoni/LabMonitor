<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
{
    if (!auth()->check() || auth()->user()->role !== 'user') {        
        return redirect()->back()->withErrors(['error' => 'Acesso negado! Apenas usuários podem acessar esta página!']);
    }

    return $next($request);
}

}
