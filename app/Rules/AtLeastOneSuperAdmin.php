<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class AtLeastOneSuperAdmin implements Rule
{
    public function passes($attribute, $value)
    {
        // Don't proceed if we're not deleting a superAdmin
        if ($value !== 'superAdmin') {
            return true;
        }

        // Check if this is the last superAdmin
        return User::where('role', 'superAdmin')->count() > 1;
    }

    public function message()
    {
        return 'The system must have at least one superAdmin.';
    }
}