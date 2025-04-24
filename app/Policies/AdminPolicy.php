<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    /**
     * Determine if the given user can register new admins.
     */
    public function registerAdmin(User $user): bool
    {
        // Only superAdmin can register new admins
        return $user->role === 'superAdmin';
    }
    
    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'superAdmin']);
    }
    
    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'superAdmin';
    }

    public function delete(User $authenticatedUser, User $userToDelete)
    {
        // Only superAdmin can delete users
        if ($authenticatedUser->role !== 'superAdmin') {
            return false;
        }
    
        // Prevent all self-deletions (both admin and superAdmin)
        if ($authenticatedUser->id === $userToDelete->id) {
            return false;
        }
    
        // SuperAdmin can delete:
        // - Regular admin accounts
        // - But not other superAdmins
        return $userToDelete->role === 'admin';
    }
}