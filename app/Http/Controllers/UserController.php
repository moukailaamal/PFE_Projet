<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\CategoryService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TechnicianDetail;
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
            $technician = TechnicianDetail::where('user_id', $user->id)->first();
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
        $technician = TechnicianDetail::findOrFail($id);
        $user = User::findOrFail($technician->user_id);
        
        $services = Service::where('technician_id', $id)->get();
        $avis = Avis::where('technician_id', $user->id)->get(); // Filtrer par user_id
    
        if ($technician->availability) {
            $technician->availability = json_decode($technician->availability, true);
        } else {
            $technician->availability = [];
        }
    
        return view('technician.details', compact('technician', 'user', 'avis', 'services'));
    }
    
public function storeAvis(Request $request)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Veuillez vous connecter pour soumettre un avis');
    }

    $validated = $request->validate([
        'technician_id' => 'required|exists:users,id',
        'rating' => 'required|integer|between:1,5',
        'comment' => 'required|string|max:500',
    ]);

    // Trouver le technicien via la table users
    $technicianUser = User::find($validated['technician_id']);
    
    // Vérifier que c'est bien un technicien
    $technicianDetail = TechnicianDetail::where('user_id', $technicianUser->id)->first();
    
    if (!$technicianDetail) {
        return back()->with('error', 'Utilisateur non trouvé comme technicien');
    }

    try {
        Avis::create([
            'client_id' => auth()->id(),
            'technician_id' => $technicianUser->id, // ID de l'utilisateur
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'review_date' => now(),
        ]);

        return redirect()
            ->route('technician.details', ['id' => $technicianDetail->id])
            ->with('success', 'Avis soumis avec succès!');

    } catch (\Exception $e) {
        \Log::error('Échec de soumission: '.$e->getMessage());
        return back()->with('error', 'Échec de soumission. Veuillez réessayer.');
    }
}
public function deleteAvis($id)
{
    // Vérifier que l'utilisateur est authentifié
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Veuillez vous connecter pour effectuer cette action');
    }

    // Récupérer l'avis
    $avis = Avis::findOrFail($id);

    // Vérifier les permissions (client OU technicien concerné)
    if (auth()->user()->id !== $avis->client_id && auth()->user()->id !== $avis->technician_id) {
        return back()->with('error', 'Action non autorisée');
    }

    try {
        // Supprimer l'avis
        $avis->delete();

        return redirect()
            ->route('technician.details', ['id' => $avis->technician_id])
            ->with('success', 'Avis supprimé avec succès!');

    } catch (\Exception $e) {
        \Log::error('Erreur suppression avis: '.$e->getMessage());
        return back()->with('error', 'Échec de la suppression');
    }
}
public function updateAvis(Request $request, $id)
{
    // Vérification d'authentification
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Veuillez vous connecter pour modifier un avis');
    }

    // Récupération de l'avis
    $avis = Avis::findOrFail($id);

    // Vérification des permissions
    if (auth()->user()->id !== $avis->client_id) {
        abort(403, 'Unauthorized action.');
    }

    // Validation
    $validated = $request->validate([
        'rating' => 'required|integer|between:1,5',
        'comment' => 'required|string|max:500',
    ]);

    // Mise à jour
    $avis->update([
        'rating' => $validated['rating'],
        'comment' => $validated['comment'],
        'review_date' => now(),
    ]);

    // Redirection avec succès
    return redirect()
        ->route('technician.details', ['id' => $avis->technician_id])
        ->with('success', 'Avis mis à jour avec succès!');
}
}
