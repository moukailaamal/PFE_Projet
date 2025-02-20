<?php

namespace App\Http\Controllers;

use Carbon\Carbon; 
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TechnicienDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Email;
use Illuminate\Support\Facades\Storage;

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

    // Afficher le formulaire d'inscription de client
    public function showRegistrationFormClient()
    {
        return view('authentification.registerClient');
    }

    // Gérer la soumission du formulaire d'inscription de client
    public function registerClient(Request $request)
    {
        $request->validate([
            'certificat' => 'required|mimes:pdf,jpg,png|max:2048',
            'identite' => 'required|mimes:pdf,jpg,png|max:2048',
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
   // Afficher le formulaire d'inscription de technicien
   public function showRegistrationFormTechnicien()
   {
       return view('authentification.registerTechnicien');
   }


   
   public function registerTechnicien(Request $request)
   {
       $request->validate([
           'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'phone_number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'gender' => 'nullable|string|in:male,female',
       
        
       ], [
           'email.unique' => 'Cet email est déjà utilisé.',
           'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
           'password.confirmed' => 'Les mots de passe ne correspondent pas.',
       ]);
   
       // 🔹 Étape 1 : Créer l'utilisateur
       $user = new User();
       $user->first_name = $request->input('first_name');
       $user->last_name = $request->input('last_name');
       $user->role = 'technician';
       $user->status = 'active'; 
       $user->registration_date = Carbon::now();
       $user->phone_number = $request->input('phone_number');
       $user->address = $request->input('address');
       $user->gender = $request->input('gender');
       $user->email = $request->input('email');
       $user->password = Hash::make($request->input('password'));
       $user->save(); // ⚠️ L'ID de l'utilisateur est généré après le save()
   
       $certificat_path = $request->file('certificat') ? $request->file('certificat')->store('public/documents/techniciens') : null;
       $identite_path = $request->file('identite') ? $request->file('identite')->store('public/documents/techniciens') : null;
       // 🔹 Étape 2 : Associer les détails du technicien
       TechnicienDetail::create([
        'user_id' => $user->id, // Clé étrangère obligatoire
        'specialty' => null,
        'rate' => null,
        'availability' => null,
        'certifications' => null,
        'description' => null,
        'certificat_path' =>  null,
        'identite_path' =>  null,

    ]);
    
   
       // 🔹 Étape 3 : Connecter et rediriger
       Auth::login($user);
   
       return redirect()->route('register.information.Technicien.form');
   }
   
 // Afficher le formulaire d'inscription de technicien
 public function showRegistrationFormTechnicienDetails($id)
 {
    $user = User::find($id);

     return view('authentification.informationTechnicien',['id' => $id,]);
 }


 
 public function registerTechnicienDetails(Request $request,$id)
 {
    $request->validate([
        'specialty' => 'required|string|max:100',
        'rate' => 'required|numeric|min:0',
        'availability' => 'required|string',
        'certificat' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'identite' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ]);

     // 🔹 Étape 1 : Créer l'utilisateur
     $technician = new TechnicienDetail();

     $certificat_path = $request->file('certificat') ? $request->file('certificat')->store('public/documents/techniciens') : null;
     $identite_path = $request->file('identite') ? $request->file('identite')->store('public/documents/techniciens') : null;
     // 🔹 Étape 2 : Associer les détails du technicien
     TechnicienDetail::create([
        'user_id' => $id,
        'specialty' => $request->input('specialty'),
        'rate' => $request->input('rate'),
        'availability' => $request->input('availability'),
        'certificat_path' => $certificat_path ? Storage::url($certificat_path) : null,
        'identite_path' => $identite_path ? Storage::url($identite_path) : null,
    ]);
 
     // 🔹 Étape 3 : Connecter et rediriger
     Auth::login($technician);
 
     return redirect()->route('login.form')->with('success', 'Inscription réussie !');
 }
    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
