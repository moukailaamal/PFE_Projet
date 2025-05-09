<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Reservation;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        
        // Additional protection against last superAdmin deletion
        if ($user->role === 'superAdmin') {
            $superAdminCount = User::where('role', 'superAdmin')->count();
            
            if ($superAdminCount <= 1) {
                return redirect()->back()
                    ->with('error', 'Cannot delete the last superAdmin account.');
            }
        }
        
        $user->delete();
        
        return redirect()->route('home')
            ->with('success', 'Account deleted successfully');
    }
    public function listClient() 
    {
        $clients = User::where('role', 'client')->paginate(10); 
        return view('admin.listClients', compact('clients'));
    }

    public function destroyClient($id)
    {
        $client = User::find($id);
        
        if(auth()->user()->role == "admin" || auth()->user()->role == "superAdmin") {
            $client->delete();
        }
        
        return redirect()->route('admin.listClients')->with('success', 'The client is successfully deleted');
    }
    public function listAdmin() 
    {
        $admins = User::whereIn('role', ['admin', 'superAdmin'])->paginate(10);
        return view('admin.listAdmins', compact('admins'));
    }
    public function listTechnician() 
    {
        
        $technicians = User::where('role', 'technician')->with('technician')->paginate(10);
        return view('admin.listTechnician', compact('technicians'));
    }
    
    public function listAllAppointement(){
        $users=User::all();
        $reservations = Reservation::with(['client', 'technician'])
        ->orderBy('appointment_date', 'asc')
        ->get();
    
        return view('admin.listsAllAppointments', compact('users', 'reservations'));
    }
 
 
    

    public function updateTechnicianStatus(Request $request, $id)
    {
        try {
            $technician = User::findOrFail($id);
            $action = $request->action;
            
            if ($action == "activate") {
                $technician->update(['status' => 'active']); 
            } elseif ($action == "reject") {  
                $technician->update(['status' => 'rejected']);
            } else {
                return redirect()->route('technician.list')
                    ->with('error', 'Invalid action requested.');
            }
            
            return redirect()->route('technician.list')
                ->with('success', 'Technician status updated successfully.');
    
        } catch (\Exception $e) {
            return redirect()->route('technician.list')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    
    
}