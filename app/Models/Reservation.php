<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'technicien_id', 'service_id', 'date_rdv', 'statut', 'date_creation'
    ];

    protected $casts = [
        'date_rdv' => 'datetime',
        'date_creation' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    public function avis()
    {
        return $this->hasOne(Avis::class);
    }
}
