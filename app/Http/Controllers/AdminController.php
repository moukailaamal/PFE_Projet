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
}