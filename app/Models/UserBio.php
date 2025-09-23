<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBio extends Model
{
    use HasFactory;

    protected $table = 'user_bios';

    protected $fillable = [
        'user_id',
        'bio',
    ];

    /**
     * ความสัมพันธ์: UserBio → User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
