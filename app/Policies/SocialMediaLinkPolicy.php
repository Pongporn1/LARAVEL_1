<?php

namespace App\Policies;

use App\Models\SocialMediaLink;
use App\Models\User;

class SocialMediaLinkPolicy
{
    /**
     * ผู้ใช้ที่ล็อกอินสามารถเห็นรายการของตัวเองได้
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * ดูรายไอดีได้เฉพาะเจ้าของ
     */
    public function view(User $user, SocialMediaLink $link): bool
    {
        return $user->id === $link->user_id;
    }

    /**
     * ใครก็สร้างลิงก์ของตัวเองได้ (ต้องล็อกอิน)
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * แก้ไขได้เฉพาะเจ้าของ
     */
    public function update(User $user, SocialMediaLink $link): bool
    {
        return $user->id === $link->user_id;
    }

    /**
     * ลบได้เฉพาะเจ้าของ
     */
    public function delete(User $user, SocialMediaLink $link): bool
    {
        return $user->id === $link->user_id;
    }

    // ไม่ใช้ในแล็บนี้ก็ปิดไว้
    public function restore(User $user, SocialMediaLink $link): bool { return false; }
    public function forceDelete(User $user, SocialMediaLink $link): bool { return false; }
}
