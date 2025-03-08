<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
         'client_id', 'technician_id', 'rating', 'comment', 'review_date'
    ];
    
    protected $casts = [
        'review_date' => 'datetime',
    ];
    
   
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
