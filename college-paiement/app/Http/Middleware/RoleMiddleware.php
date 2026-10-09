<?php
// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $user = Auth::user();
        
        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        
        // Redirection selon le rôle
        if ($user->role === 'gestionnaire_systeme') {
            return redirect()->route('gestionnaire.dashboard')->with('error', 'Accès non autorisé.');
        }
        if ($user->role === 'comptable') {
            return redirect()->route('comptable.dashboard')->with('error', 'Accès non autorisé.');
        }
        if ($user->role === 'parent') {
            return redirect()->route('parent.dashboard')->with('error', 'Accès non autorisé.');
        }

        return redirect()->route('login')->with('error', 'Accès non autorisé.');
    }
}