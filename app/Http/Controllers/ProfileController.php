<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\CategoryService;
use App\Models\TechnicianDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        try {
            $user = Auth::user();
            $technician = null;
            $categories = CategoryService::all();
            
            if ($user->role == 'technician') {
                $technician = TechnicianDetail::where('user_id', $user->id)->first();
                return view('profile.edit', compact('user', 'technician', 'categories'));
            }
            
            return view('profile.edit', compact('user'));
            
        } catch (\Exception $e) {
            // Log the error and return a basic view
            Log::error('Profile edit error: ' . $e->getMessage());
            return view('profile.edit', ['user' => Auth::user() ?? new User()]);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
            if (!$user) {
                return redirect()->route('home')->with('error', 'Utilisateur non trouvé.');
            }
        
            // Vérifier que l'utilisateur authentifié est bien celui qui met à jour son profil
            if (!Auth::check() || Auth::id() != $user->id) {
                return redirect()->route('home')->with('error', 'Vous n\'avez pas l\'autorisation de mettre à jour ce profil.');
            }
        
            // Validation des données
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|:users,email,' ,
                'password' => 'nullable|string|min:8|confirmed',
                'phone_number' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'gender' => 'nullable|string|in:male,female',
                'photo' => 'nullable|file|mimes:jpg,png|max:2048', // Photo validation for all users
                'specialty' => 'required_if:user.role,technician|string|max:255',
                'location' => 'required_if:user.role,technician|string|max:255',
                'rate' => 'required_if:user.role,technician|numeric|min:0',
                'availability' => 'required_if:user.role,technician|json',
                'description' => 'nullable|string|max:500',
                'category_id' => 'required_if:user.role,technician|exists:category_services,id',
            ]);
        
            // Traitement de la photo (pour tous les utilisateurs)
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                // Enregistrer la nouvelle photo
                $user->photo = $request->file('photo')->store('user_photos', 'public');
            }
        
            // Mise à jour des informations de base (pour tous les utilisateurs)
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'address' => $request->input('address'),
                'gender' => $request->input('gender'),
                'photo' => $user->photo, // Assurez-vous que la photo est incluse
            ]);
        
            // Traitement spécifique aux techniciens
            if ($user->role == 'technician') {
                $technician = TechnicianDetail::where('user_id', $user->id)->first();
        
                if (!$technician) {
                    return redirect()->route('home')->with('error', 'Détails du technicien introuvables.');
                }
        
                // Vérifier et décoder le JSON
                $availability = json_decode($request->input('availability'), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return redirect()->back()->withErrors(['availability' => 'Le format JSON est invalide.']);
                }
        
                foreach ($availability as $slot) {
                    if (!isset($slot['day']) || !isset($slot['start_time']) || !isset($slot['end_time'])) {
                        return redirect()->back()->withErrors(['availability' => 'La structure JSON est incorrecte.']);
                    }
                }
        
                // Mise à jour des informations du technicien
                $technician->update([
                    'specialty' => $request->input('specialty'),
                    'price' => $request->input('price'),
                    'availability' => $request->input('availability'), // Utilisation du JSON
                    'description' => $request->input('description'),
                    'category_id' => $request->input('category_id'),
                    'location' => $request->input('location'),
                ]);
        
                // Gestion des fichiers pour les techniciens
                if ($request->hasFile('certificat_path')) {
                    if ($technician->certificat_path) {
                        Storage::disk('public')->delete($technician->certificat_path);
                    }
                    $technician->certificat_path = $request->file('certificat_path')->store('technicians_certificats', 'public');
                    $technician->save(); // Sauvegarder après la mise à jour du fichier
                }
        
                if ($request->hasFile('identite_path')) {
                    if ($technician->identite_path) {
                        Storage::disk('public')->delete($technician->identite_path);
                    }
                    $technician->identite_path = $request->file('identite_path')->store('technicians_identite', 'public');
                    $technician->save(); // Sauvegarder après la mise à jour du fichier
                }
            }
        
            return redirect()->route('profile.edit')->with('status', 'Profile updated successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/home');
    }
}
