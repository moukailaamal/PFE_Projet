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

    public function login(Request $request)
    {
        // Validation des données de connexion
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Tentative de connexion de l'utilisateur
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Connexion réussie, redirection avec un message de succès
            session(['id' => Auth::id()]);

            return redirect()->route('profile.form')->with('success', 'Connexion réussie');
        }
    
        // Échec de la connexion, retour avec un message d'erreur
        return back()->withErrors(['email' => 'Les informations d\'identification sont incorrectes.'])->with('error', 'Échec de la connexion');
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
        $auth->status = 'active'; 
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
           'certificat_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
           'identite_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
       ], [
           'email.unique' => 'Cet email est déjà utilisé.',
           'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
           'password.confirmed' => 'Les mots de passe ne correspondent pas.',
       ]);
       try {
       // Créer l'utilisateur
       $user = new User();
       $user->first_name = $request->input('first_name');
       $user->last_name = $request->input('last_name');
       $user->role = 'technician';
       $user->status = 'inactive'; 
       $user->registration_date = Carbon::now();
       $user->phone_number = $request->input('phone_number');
       $user->address = $request->input('address');
       $user->gender = $request->input('gender');
       $user->email = $request->input('email');
       $user->password = Hash::make($request->input('password'));
       $user->save(); // Sauvegarde l'utilisateur et génère son ID
   
       // Gestion des fichiers
       $certificat_path = $request->file('certificat_path') 
           ? $request->file('certificat_path')->store('public/documents/techniciens') 
           : null;
       $identite_path = $request->file('identite_path') 
           ? $request->file('identite_path')->store('public/documents/techniciens') 
           : null;
   
       // Associer les détails du technicien
       $technician = new TechnicienDetail();
       $technician->user_id = $user->id;  // Utilise l'ID généré après la sauvegarde de l'utilisateur
       $technician->specialty = null;  // Valeur par défaut ou à ajuster
       $technician->rate = null;      // Valeur par défaut ou à ajuster
       $technician->availability = null;  // À remplir si nécessaire
       $technician->certificat_path = $certificat_path;
       $technician->identite_path = $identite_path;

       $technician->save();    

       // Connecter l'utilisateur et rediriger
       Auth::login($user);
   
       return redirect()->route('login.form')->with('status', 'Inscription réussie !');
    } catch (\Exception $e) {
 // Message d'erreur
 return redirect()->back()->with('error', 'Échec de l\'inscription. Veuillez réessayer.');
   }
}
   
   
   
   
 // Afficher le formulaire d'inscription de technicien
 public function showRegistrationFormTechnicienDetails($id)
 {
    $user = User::find($id);

     return view('authentification.informationTechnicien',['id' => $id,]);
 }


    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
