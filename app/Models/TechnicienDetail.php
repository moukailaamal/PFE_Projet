<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicienDetail extends Model
{
    protected $table = 'techniciens_details'; 
    protected $fillable = [
        'user_id', 'specialty', 'working_hours', 'location', 'category_id', 
        'rate', 'availability', 'certifications', 'description', 
        'certificate_path', 'identity_path', 'verification_status'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function categoryService()
    {
        return $this->belongsTo(CategoryService::class, 'category_id');
    }
}
