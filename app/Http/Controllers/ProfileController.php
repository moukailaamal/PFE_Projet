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
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    
    // Update basic fields from the validated request
    $user->fill($request->validated());

    // Handle email verification
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Handle profile photo upload
    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        // Store new photo
        $user->photo = $request->file('photo')->store('user_photos', 'public');
    }

    // Handle password update if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // Save the user
    $user->save();

    // Handle technician-specific updates
    if ($user->role == 'technician') {
        $technician = TechnicianDetail::where('user_id', $user->id)->firstOrFail();

        // Validate technician-specific fields
        $technicianData = $request->validate([
            'specialty' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'availability' => 'required|json',
            'description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:category_services,id',
        ]);

        // Validate availability JSON
        $availability = json_decode($technicianData['availability'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()
                ->withErrors(['availability' => 'Le format JSON est invalide.'])
                ->withInput();
        }

        foreach ($availability as $slot) {
            if (!isset($slot['day']) || !isset($slot['start_time']) || !isset($slot['end_time'])) {
                return redirect()->back()
                    ->withErrors(['availability' => 'La structure JSON est incorrecte.'])
                    ->withInput();
            }
        }

        // Update technician details
        $technician->update($technicianData);

        // Handle technician files
        if ($request->hasFile('certificat_path')) {
            if ($technician->certificat_path) {
                Storage::disk('public')->delete($technician->certificat_path);
            }
            $technician->certificat_path = $request->file('certificat_path')
                ->store('technicians_certificats', 'public');
        }

        if ($request->hasFile('identite_path')) {
            if ($technician->identite_path) {
                Storage::disk('public')->delete($technician->identite_path);
            }
            $technician->identite_path = $request->file('identite_path')
                ->store('technicians_identite', 'public');
        }

        $technician->save();
    }

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
