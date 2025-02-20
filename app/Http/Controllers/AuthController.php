<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon; 
use Illuminate\Validation\Rules\Email;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('authentification.login');
    }

    // Gérer la soumission du formulaire de connexion
    public function login(Request $request)
    {
        // Validation des données de connexion
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Tentative de connexion de l'utilisateur
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/dashboard'); // Redirige vers la page d'accueil ou tableau de bord
        }

        return back()->withErrors(['email' => 'Les informations d\'identification sont incorrectes.']);
    }

    // Afficher le formulaire d'inscription
    public function showRegistrationFormClient()
    {
        return view('authentification.registerClient');
    }

    // Gérer la soumission du formulaire d'inscription
    public function registerClient(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email', // Vérifie que l'email est unique et valide
            'password' => 'required|string|min:8|confirmed', // Vérifie que le mot de passe est confirmé
        ], [
            'email.unique' => 'Cet email est déjà utilisé. Veuillez en choisir un autre.',
            'email.required' => 'L\'email est requis.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);
        
        // Créer un nouvel utilisateur
        $auth = new User();
        $auth->first_name = $request->input('first_name');
        $auth->last_name = $request->input('last_name');
        $auth->role = 'client';
        $auth->status = 'inactive'; 
        $auth->registration_date = Carbon::now();
        $auth->phone_number = $request->input('phone_number');
        $auth->address = $request->input('address');
        $auth->gender = $request->input('gender');
        $auth->email = $request->input('email');
        $auth->password = Hash::make($request->input('password'));
        $auth->save();
        
        // Connecter l'utilisateur
        Auth::login($auth);
        
        // Rediriger vers la page de connexion avec succès
        return redirect()->route('login.form')->with('success', 'Inscription réussie !');
                
    }

    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
