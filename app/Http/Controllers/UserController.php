<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\CategoryService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TechnicienDetail;
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
    
        $technician = null;
        $catgories=CategoryService::all();
        if ($user->role == 'technician') {
            $technician = TechnicienDetail::where('user_id', $user->id)->first();
            return view('technician.profile', compact('user', 'technician','catgories'));
        } elseif ($user->role == 'client') {
           
            return view('technician.profile', compact('user'));
        }
    
        return redirect()->route('login.form')->with('error', 'Rôle non reconnu.');
    }
    
    public function update(Request $request, $id)
    {
        // Vérifier que l'utilisateur existe
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('home')->with('error', 'Utilisateur non trouvé.');
        }
    
        // Vérifier que l'utilisateur authentifié est bien celui qui met à jour son profil
        if (!Auth::check() || Auth::id() != $id) {
            return redirect()->route('home')->with('error', 'Vous n\'avez pas l\'autorisation de mettre à jour ce profil.');
        }
    
        // Validation des données
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female',
            'photo' => 'nullable|file|mimes:jpg,png|max:2048',
            'specialty' => 'required_if:user.role,technician|string|max:255',
            'location' => 'required_if:user.role,technician|string|max:255',
            'rate' => 'required_if:user.role,technician|numeric|min:0',
            'availability' => 'required|json',
            'description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:category_services,id',
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
            $technician = TechnicienDetail::where('user_id', $user->id)->first();
    
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
                'rate' => $request->input('rate'),
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
    
        return redirect()->route('profile.form')->with('success', 'Profil mis à jour avec succès.');
    }
 public function InformationTechnician($id) {
    
    $services = Service::where('technician_id', $id)->get();
    $avis = Avis::all();
    $technician = TechnicienDetail::find($id);
    $idUser=$technician->user_id;
    $user = User::find($idUser);
    // Décoder le champ availability
    if ($technician && $technician->availability) {
        $technician->availability = json_decode($technician->availability, true);
    } else {
        $technician->availability = []; // Valeur par défaut si vide ou null
    }

    // Passer les données à la vue
    return view('technician.details', compact('technician', 'user', 'avis','services'));
}
    
    public function storeAvis(Request $request){
        $avis = new Avis();
        $avis->client_id = $request->client_id;
        $avis->technician_id = $request->technician_id;
        $avis->rating = $request->rating;
        $avis->comment = $request->comment;
        $avis->review_date = now(); // Use the current date and time
        $avis->save();
    
        return redirect()->route('technician.details', ['id' => $request->technician_id])->with('success', 'Review added successfully');
    }
    
    
}
