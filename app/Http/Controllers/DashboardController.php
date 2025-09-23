<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // 👈 ใช้คำนวณ/ฟอร์แมตวันเกิด

class DashboardController extends Controller
{
    /**
     * Show the application dashboard with profile photo and birthdate.
     */
    public function index()
    {
        // ดึงผู้ใช้ปัจจุบัน + นับลิงก์แบบ loadCount เร็วกว่า
        $user = Auth::user()->loadCount('socialMediaLinks');

        // วันเกิด (รองรับกรณีค่าว่าง)
        // ถ้าใน Model User มี casts ['birthdate' => 'date'] แล้ว จะเป็น Carbon อยู่แล้ว
        $birthdate = $user->birthdate
            ? ($user->birthdate instanceof Carbon ? $user->birthdate : Carbon::parse($user->birthdate))
            : null;

        $birthdateLabel = $birthdate?->format('d M Y'); // เช่น 15 Sep 2025
        $ageYears       = $birthdate?->age;             // อายุเป็นปี (int | null)

        // สถิติสำหรับการ์ด
        $stats = [
            'links_count' => $user->social_media_links_count, // มาจาก loadCount
            'joined_days' => $user->created_at?->diffInDays(now()) ?? 0,
        ];

        // ส่งไปที่ dashboard.blade.php
        return view('dashboard', [
            'user'           => $user,
            'stats'          => $stats,
            'birthdateLabel' => $birthdateLabel,
            'ageYears'       => $ageYears,
            // หมายเหตุ: รูปโปรไฟล์เรียกใน Blade ผ่าน $user->avatar_url (accessor ที่เราเติมใน User.php)
        ]);
    }
}
