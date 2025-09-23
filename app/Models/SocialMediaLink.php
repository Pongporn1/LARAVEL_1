<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaLink extends Model
{
    use HasFactory;

    protected $fillable = ['platform_name', 'url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
    