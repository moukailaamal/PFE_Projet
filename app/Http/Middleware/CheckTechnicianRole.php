<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTechnicianRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est un technicien actif
        if ($request->user()->role !== 'technician') {
            return redirect()->route('home');
        }

      
        return $next($request);
    }
}