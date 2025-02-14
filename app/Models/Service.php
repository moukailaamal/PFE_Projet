<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'technicien_id', 'categorie_id', 'titre', 'description', 'tarif', 'date_creation'
    ];

    protected $casts = [
        'date_creation' => 'datetime',
    ];

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryService::class, 'categorie_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
