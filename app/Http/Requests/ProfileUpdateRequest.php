<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'in:male,female'],
            'photo' => ['nullable', 'file', 'mimes:jpg,png', 'max:2048'],
        ];
    
        // Add technician-specific validation if user is technician
        if ($this->user()->role == 'technician') {
            $rules = array_merge($rules, [
                'specialty' => ['required', 'string', 'max:255'],
                'location' => ['required', 'string', 'max:255'],
                'rate' => ['required', 'numeric', 'min:0'],
                'availability' => ['required', 'json'],
                'description' => ['nullable', 'string', 'max:500'],
                'category_id' => ['required', 'exists:category_services,id'],
                'certificat_path' => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
                'identite_path' => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            ]);
        }
    
        return $rules;
    }

    /**
     * Handle the passed validation.
     */
    protected function passedValidation(): void
    {
        // Vous pouvez ajouter ici une logique post-validation si nécessaire
    }
}