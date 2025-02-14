<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id', 'client_id', 'technicien_id', 'note', 'commentaire', 'date_avis'
    ];

    protected $casts = [
        'date_avis' => 'datetime',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }
}
