<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed emotions ก่อน (ถ้ามี EmotionSeeder อยู่จริง)
        $this->call(EmotionSeeder::class);

        // สร้าง user ที่ล็อกอินได้จริง
        User::updateOrCreate(
            ['email' => 'ballboss6183@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'), // รหัสผ่านนี้ใช้ล็อกอินได้เลย
                
            ]
        );

        $this->call(TagSeeder::class);
    }
}
