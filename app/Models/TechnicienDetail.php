<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicienDetail extends Model
{
    protected $fillable = [
        'user_id', 'specialite', 'tarif', 'disponibilite', 'certifications', 'description', 'certificat_path', 'identite_path', 'verification_status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
