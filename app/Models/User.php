<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'address', 'gender',
        'role', 'phone_number', 'registration_date', 'status', 'photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'registration_date' => 'datetime',
    ];

    public function technician()
    {
        return $this->hasOne(TechnicianDetail::class, 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id')
            ->orWhere('technician_id', $this->id);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function avisAsTechnician()
    {
        return $this->hasMany(Avis::class, 'technician_id');
    }
}