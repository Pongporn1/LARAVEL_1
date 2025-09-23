<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'remind_at', 'status'];

    // 👇 เพิ่ม/ยืนยันบรรทัดนี้
    protected $casts = [
        'remind_at' => 'datetime', // หรือ 'datetime:Y-m-d H:i'
    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
}
