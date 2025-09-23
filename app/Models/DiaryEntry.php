<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaryEntry extends Model
{
    protected $table = 'diary_entries';

    protected $fillable = ['user_id', 'date', 'title', 'content'];

    protected $casts = [
        'date'       => 'date',     // << ใช้ cast เป็น date
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function emotions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
   {
    return $this->belongsToMany(Emotion::class, 'diary_entry_emotions', 'diary_entry_id', 'emotion_id')
                ->withPivot('intensity')
                ->withTimestamps();
   }

   public function tags()
   {
    return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
   }


}
