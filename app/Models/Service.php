<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services'; 

    protected $fillable = [
        'technician_id', 'category_id', 'title', 
    ];

    protected $casts = [
        'date_creation' => 'datetime',
    ];

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

   
    public function category()
{
    return $this->belongsTo(CategoryService::class, 'category_id');
}


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
