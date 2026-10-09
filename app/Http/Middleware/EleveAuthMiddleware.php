<?php
// app/Http/Middleware/EleveAuthMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EleveAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('eleve_id')) {
            return redirect()->route('eleve.login')->with('error', 'Veuillez vous connecter.');
        }
        return $next($request);
    }
}