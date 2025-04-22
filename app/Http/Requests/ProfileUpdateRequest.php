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
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'gender' => ['required', 'in:male,female,other'],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string', 'max:255'],
            
            // Pour les techniciens seulement
            'certificat_path' => ['sometimes', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'identite_path' => ['sometimes', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ];
    }

    /**
     * Handle the passed validation.
     */
    protected function passedValidation(): void
    {
        // Vous pouvez ajouter ici une logique post-validation si nécessaire
    }
}