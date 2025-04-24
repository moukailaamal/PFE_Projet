<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role !== 'superAdmin') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}