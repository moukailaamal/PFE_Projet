<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id', 'envoyeur_id', 'contenu', 'date_envoi'
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function envoyeur()
    {
        return $this->belongsTo(User::class, 'envoyeur_id');
    }
}
