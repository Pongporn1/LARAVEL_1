<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',   // path รูปโปรไฟล์
        'birthdate',       // วันเกิด
    ];

    /**
     * Relations
     */
    public function socialMediaLinks(): HasMany
    {
        return $this->hasMany(\App\Models\SocialMediaLink::class);
    }

    /**
     * One-to-One: User -> UserBio
     * ทำให้ $user->bio() และ $user->bio ใช้งานได้
     */
    public function bio(): HasOne
    {
        return $this->hasOne(\App\Models\UserBio::class, 'user_id');
    }

    /**
     * (ทางเลือก) alias เผื่อที่อื่นเรียก userBio()
     */
    public function userBio(): HasOne
    {
        return $this->hasOne(\App\Models\UserBio::class, 'user_id');
    }

    /**
     * Hidden
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'birthdate'         => 'date',   // => Carbon instance
        ];
    }

    /**
     * Accessor: URL รูปโปรไฟล์ (fallback เป็น avatar อักษรย่อ)
     */
    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->profile_photo)) {
            return route('user.photo', ['filename' => $this->profile_photo]);
        }
        $seed = urlencode($this->name ?? 'User');
        return "https://api.dicebear.com/7.x/initials/svg?seed={$seed}";
    }

    /**
     * Accessor: ป้ายวันเกิด (เช่น 03 Oct 2003)
     */
    public function getBirthdateLabelAttribute(): ?string
    {
        return $this->birthdate?->format('d M Y');
    }

    /**
     * Accessor: อายุ (ปี)
     */
    public function getAgeAttribute(): ?int
    {
        return $this->birthdate?->age;
    }

    /**
     * Mutator: ตั้งค่า birthdate ให้เป็น Y-m-d เสมอ
     * รองรับทั้ง '2003-10-03' และ '03/10/2003'
     */
    public function setBirthdateAttribute($value): void
    {
        if (blank($value)) {
            $this->attributes['birthdate'] = null;
            return;
        }

        // ลอง parse แบบทั่วไปก่อน (Y-m-d, natural language)
        try {
            $this->attributes['birthdate'] = Carbon::parse($value)->format('Y-m-d');
            return;
        } catch (\Throwable $e) {
            // no-op
        }

        // รองรับรูปแบบ d/m/Y เช่น 03/10/2003
        $this->attributes['birthdate'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function diaryEntries()
    {
        return $this->hasMany(\App\Models\DiaryEntry::class);
    }
}
