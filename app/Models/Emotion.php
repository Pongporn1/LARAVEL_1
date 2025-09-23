<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Emotion extends Model
{
    protected $table = 'emotions';

    protected $fillable = ['name', 'description'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /** @return BelongsToMany<DiaryEntry> */
    public function diaryEntries(): BelongsToMany
    {
        return $this->belongsToMany(DiaryEntry::class, 'diary_entry_emotions', 'emotion_id', 'diary_entry_id')
                    ->withPivot('intensity')
                    ->withTimestamps();
    }
}
