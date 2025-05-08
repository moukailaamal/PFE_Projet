<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTechnicianRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Allow non-technicians to pass (other middleware handles them)
        if ($user->role !== 'technician') {
            return $next($request);
        }
        
        // Technician-specific checks
        switch ($user->status) {
            case 'pending':
                auth()->logout();
                return redirect()->route('login')
                    ->with('error', 'Your account is pending approval. Please wait for admin validation.');
            
            case 'rejected':
                auth()->logout();
                return redirect()->route('login')
                    ->with('error', 'Your account has been rejected by admin.');
            
            case 'active':
                return $next($request); // Allow active technicians
                
            default:
                // Logout if status is unknown/unsupported
                auth()->logout();
                return redirect()->route('login')
                    ->with('error', 'Your account status is invalid or not supported.');
        }
    }
}