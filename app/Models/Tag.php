<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// ถ้าใช้ทั้งสองโมเดลก็นำเข้าไว้ (ถ้า DiaryEntry ไม่มีในโปรเจกต์ ให้เอา use อันนั้นออก)
use App\Models\Reminder;
use App\Models\DiaryEntry;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * สิ่งที่ถูก tag ประเภท Reminder (polymorphic many-to-many)
     * taggables.taggable_type = App\Models\Reminder
     */
    public function reminders()
    {
        return $this->morphedByMany(Reminder::class, 'taggable')->withTimestamps();
    }

    /**
     * สิ่งที่ถูก tag ประเภท DiaryEntry (ถ้ามี)
     * taggables.taggable_type = App\Models\DiaryEntry
     */
    public function diaryEntries()
    {
        return $this->morphedByMany(DiaryEntry::class, 'taggable')->withTimestamps();
    }
}
