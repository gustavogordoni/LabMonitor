<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next): Response
{
    if (!auth()->check() || auth()->user()->role !== 'student') {        
        return redirect()->back()->withErrors(['error' => 'Acesso negado! Apenas alunos podem acessar esta página!']);
    }

    return $next($request);
}

}
