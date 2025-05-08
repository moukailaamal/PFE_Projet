<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
    
        $user = Auth::user();
    
        // Check if user has allowed role
        if (!in_array($user->role, ['technician', 'client'])) {
            Auth::guard('web')->logout();
            throw ValidationException::withMessages([
                'email' => __('auth.unauthorized_role'),
            ]);
        }
    
        // Technician-specific checks
        if ($user->role === 'technician') {
            if ($user->status === 'pending') {
                Auth::guard('web')->logout();
                return redirect()->route('login')
                    ->with('error', 'Your account is pending approval. Please wait for admin validation.');
            }
    
            if ($user->status === 'rejected') {
                Auth::guard('web')->logout();
                return redirect()->route('login')
                    ->with('error', 'Your certificate and identification do not meet platform requirements.');
            }
        }
    
        // Role-based redirection
        $redirectTo = match($user->role) {
            'technician' => route('home'), 
            'client'     => route('home'),
            default      => route('home')
        };
    
        return redirect()->intended($redirectTo);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/home');
    }
}