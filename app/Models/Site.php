<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'user_id',
        'site_name',
        'site_logo',
        'site_description',
        'site_keywords',
        'site_slogan',
        'site_url',
        'theme',
        'components',
        'pages',
        'menus',
    ];

    protected $casts = [
        'components' => 'array',
        'pages' => 'array',
        'menus' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
