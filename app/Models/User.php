<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password','address','gender',
         'role','phone_number', 'registration_date', 'status','photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $casts = [
        'date_inscription' => 'datetime',
    ];

    public function technicienDetails()
    {
        return $this->hasOne(TechnicienDetail::class);
    }
// Dans app/Models/User.php
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
