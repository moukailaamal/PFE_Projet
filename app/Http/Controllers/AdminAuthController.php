<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AdminAuthController extends Controller
{
    use AuthorizesRequests;
    public function showLoginForm()
    {
        return view('admin.auth.login'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => ['admin', 'superAdmin']])) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Invalid admin credentials',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function showRegistrationForm()
{
    try {
        $this->authorize('registerAdmin', User::class);
        return view('admin.auth.register');
    } catch (AuthorizationException $e) {
        return redirect()->route('admin.register')
            ->with('error', 'You are not authorized to register admins!');
    }
}

public function register(Request $request)
{
    $this->authorize('registerAdmin', User::class);

    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'gender' => ['required', 'string', 'in:male,female,other'],
        'role' => ['required', 'string', 'in:admin,superAdmin'],

        'address' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:20'],
    ]);

    User::create([
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'email' => $validated['email'],
        'gender' => $validated['gender'],
        'address' => $validated['address'],
        'phone_number' => $validated['phone_number'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'],
        'status' => 'active',
        'registration_date' => now(),
        'email_verified_at' => now(),
    ]);

    return redirect()->route('home')
        ->with('success', 'Admin registered successfully!');
}


   
}