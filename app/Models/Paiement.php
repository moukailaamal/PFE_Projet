<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'client_id',
        'reservation_id',
        'technician_id',
        'amount',
        'payment_method',
        'status',
        'payment_date',
    ];

    public function reservation()
{
    return $this->hasOne(Reservation::class);
}

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}