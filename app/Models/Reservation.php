<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'technician_id', 'service_id', 'appointment_date', 'status', 'creation_date'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'creation_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technician_id');
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
