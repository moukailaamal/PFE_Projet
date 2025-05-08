<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TechnicianDetail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function createClient(): View
    {
        return view('auth.registerClient');
    }

    /**
     * Display the technician registration view.
     */
    public function createTechnician(): View
    {
        return view('auth.registerTechnician');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        
        // Common validation rules for ALL users (clients & technicians)
        $validationRules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|in:male,female,other',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'terms' => 'required|accepted',
        ];
    
        // Add technician-specific validation ONLY if role is 'technician'
        if ($request->role === 'technician') {
            $validationRules['identite_path'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $validationRules['certificat_path'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }
    
        $validatedData = $request->validate($validationRules);
        $status = $request->role === 'technician' ? 'pending' : 'active';

        // Create the user (client or technician)
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $request->role, // 'client' or 'technician' (from form input)
            'gender' => $validatedData['gender'],
            'phone_number' => $validatedData['phone_number'],
            'address' => $validatedData['address'],
            'status' => $status,
            'registration_date' => Carbon::now(),
        ]);
    
        // Only create TechnicianDetail if role is 'technician'
       
        if ($request->role === 'technician') {
            try {
                // Store files with explicit visibility
                $certificatPath = $request->file('certificat_path')->storeAs(
                    'technicians/certificats',
                    'cert_'.$user->id.'.'.$request->file('certificat_path')->extension(),
                    'public'
                );
    
                $identitePath = $request->file('identite_path')->storeAs(
                    'technicians/identites',
                    'id_'.$user->id.'.'.$request->file('identite_path')->extension(),
                    'public'
                );
    
                // Create technician details with explicit field assignment
                $techDetails = new TechnicianDetail();
                $techDetails->user_id = $user->id;
                $techDetails->certificat_path = $certificatPath;
                $techDetails->identite_path = $identitePath;
                $techDetails->verification_status = 'pending';
                $techDetails->save();
    
            } catch (\Exception $e) {
                // Delete user if something fails
                $user->delete();
                return back()->with('error', 'File upload failed: '.$e->getMessage());
            }
        }
    
        event(new Registered($user));
         // Handle redirection based on user type
    if ($request->role === 'technician') {
        return redirect()->route('register.success');
    }
        Auth::login($user);
        
        return redirect()->route('verification.notice');
    }
}