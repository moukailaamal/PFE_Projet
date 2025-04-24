<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function listTechnician() 
    {
        $technicians = User::where('role', 'technician')->with('technician')->get();
        return view('admin.listTechnician', compact('technicians'));
    }
    

    public function activeTechnicianStatus($id)
    {
        $technician = User::findOrFail($id);
    
        if ($technician->status !== 'active') {
            $technician->update(['status' => 'active']);
            return redirect()->back()->with('success', 'Technician status activated successfully.');
        }
    
        return redirect()->back()->with('error', 'Technician is already active.');
    }
    
    public function inactiveTechnicianStatus($id)
    {
        $technician = User::findOrFail($id);
    
        if ($technician->status === 'active') {
            $technician->update(['status' => 'inactive']);
            return redirect()->back()->with('success', 'Technician status deactivated successfully.');
        }
    
        return redirect()->back()->with('error', 'Only active technicians can be deactivated.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        
        // Additional protection against last superAdmin deletion
        if ($user->role === 'superAdmin') {
            $superAdminCount = User::where('role', 'superAdmin')->count();
            
            if ($superAdminCount <= 1) {
                return redirect()->back()
                    ->with('error', 'Cannot delete the last superAdmin account.');
            }
        }
        
        $user->delete();
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Account deleted successfully');
    }
}