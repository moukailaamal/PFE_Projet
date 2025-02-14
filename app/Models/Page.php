<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['sitemap_exclude', 'url', 'updated_at', 'sitemap_changefreq', 'sitemap_priority'];

}
