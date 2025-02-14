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
        'nom', 'prenom', 'email', 'mot_de_passe', 'role', 'date_inscription', 'statut'
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

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
}
