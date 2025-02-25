<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TechnicienDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Veuillez vous connecter.');
        }
    
        $technician = null; // Initialisation pour éviter les erreurs
    
        if ($user->role == 'technician') {
            $technician = TechnicienDetail::where('user_id', $user->id)->first();
            return view('profile', compact('user', 'technician'));
        } elseif ($user->role == 'client') {
            return view('profile', compact('user'));
        }
    
        return redirect()->route('login.form')->with('error', 'Rôle non reconnu.');
    }
    
    public function update(Request $request, $id)
    {
        // Vérifier que l'utilisateur existe avant toute validation
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('exemple')->with('error', 'Utilisateur non trouvé.');
        }
    
        // Vérifier que l'utilisateur authentifié est bien celui qui met à jour son profil
        if (!Auth::check() || Auth::id() != $id) {
            return redirect()->route('exemple')->with('error', 'Vous n\'avez pas l\'autorisation de mettre à jour ce profil.');
        }
    
        // Validation des données avec des règles adaptées
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Autoriser l'email actuel
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female',
            'certificat_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'identite_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'photo' => 'nullable|file|mimes:jpg,png|max:2048',
            'specialty' => 'required_if:user.role,technician|string|max:255',
            'rate' => 'required_if:user.role,technician|numeric|min:0',
            'availability' => 'required_if:user.role,technician|string|max:255',
            'description' => 'nullable|string|max:500',
        ], [
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);
    
        // Si une photo est téléchargée, la traiter
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            // Enregistrer la nouvelle photo
            $user->photo = $request->file('photo')->store('user_photo', 'public');
        }

        // Mise à jour des informations utilisateur (en excluant la photo pour la mise à jour ci-dessus)
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
        ]);
    
        // Si l'utilisateur est un technicien, mettre à jour ses détails
        if ($user->role == 'technician') {
            $technician = TechnicienDetail::where('user_id', $user->id)->first();
    
            if (!$technician) {
                return redirect()->route('exemple')->with('error', 'Détails du technicien introuvables.');
            }
    
            $technician->update([
                'specialty' => $request->input('specialty'),
                'rate' => $request->input('rate'),
                'availability' => $request->input('availability'),
                'description' => $request->input('description'),
            ]);
    
            // Gestion des fichiers avec stockage sécurisé
            if ($request->hasFile('certificat_path')) {
                if ($technician->certificat_path) {
                    Storage::disk('public')->delete($technician->certificat_path);
                }
                $technician->certificat_path = $request->file('certificat_path')->store('technicians_certificats', 'public');
            }
    
            if ($request->hasFile('identite_path')) {
                if ($technician->identite_path) {
                    Storage::disk('public')->delete($technician->identite_path);
                }
                $technician->identite_path = $request->file('identite_path')->store('technicians_identite', 'public');
            }
    
            $technician->save();
        }
    
        return redirect()->route('profile.form')->with('success', 'Profil mis à jour avec succès.');
    }
}
