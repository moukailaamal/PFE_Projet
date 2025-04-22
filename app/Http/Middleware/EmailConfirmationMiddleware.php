<?php

//app/Http/Middleware/EmailConfirmationMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EmailConfirmationMiddleware
{
    public function handle($request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté et que son adresse e-mail est confirmée
        if (Auth::check() && !Auth::user()->isEmailConfirmed()) {
            return redirect()->route('login')->with('error', 'Veuillez confirmer votre adresse e-mail.');
        }

        return $next($request);
    }
}
