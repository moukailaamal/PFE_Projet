<?php

namespace App\Http\Controllers;

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
        $categories = CategoryService::all();
        
        return view('profile.edit', [
            'user' => $request->user(),
            'categories' => $categories 
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validation
        $validated = $request->validate([
            // ... your validation rules from above ...
        ]);
    
        // Update user fields if they exist in the request
        $userFields = ['first_name', 'last_name', 'email', 'phone_number', 'address', 'gender'];
        foreach ($userFields as $field) {
            if ($request->has($field)) {
                $user->$field = $request->input($field);
            }
        }
    
        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('user_photos', 'public');
        }
    
        $user->save();
    
        // Handle technician fields
        if ($user->role == 'technician') {
            $technician = TechnicianDetail::where('user_id', $user->id)->firstOrFail();
    
            $technicianFields = ['specialty', 'price', 'location', 'description', 'category_id'];
            foreach ($technicianFields as $field) {
                if ($request->has($field)) {
                    $technician->$field = $request->input($field);
                }
            }
    
            // Handle availability
            if ($request->has('availability')) {
                $availability = json_decode($request->input('availability'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $technician->availability = $request->input('availability');
                }
            }
    
            // Handle file uploads
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
