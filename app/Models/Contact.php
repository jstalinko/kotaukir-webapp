<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'name',
        'email',
        'message',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
