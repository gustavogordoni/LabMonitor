<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            
            return redirect()->back()->withErrors(['error' => 'Acesso negado! Apenas administradores podem acessar esta página!']);
        }

        return $next($request);
    }
}
