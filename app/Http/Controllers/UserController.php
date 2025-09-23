<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct()
    {
        // ให้เข้าถึงได้เฉพาะผู้ใช้ที่ล็อกอิน (และยืนยันอีเมลแล้ว หากใช้ verified)
        $this->middleware(['auth', 'verified']);
    }

    /**
     * อัปเดตรูปโปรไฟล์ (เก็บไฟล์ไว้ที่ storage/app/private/profile_photos)
     */
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // ลบรูปเดิมถ้ามี
        if (!empty($user->profile_photo)) {
            File::delete(storage_path('app/private/profile_photos/' . $user->profile_photo));
        }

        // ตั้งชื่อไฟล์ใหม่และบันทึก
        $fileName = time().'_'.$user->id.'_'.$request->file('profile_photo')->getClientOriginalName();
        $request->file('profile_photo')->storeAs('private/profile_photos', $fileName); // ใช้ default 'local'

        // อัปเดตชื่อไฟล์ในฐานข้อมูล
        $user->profile_photo = $fileName;
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-photo-updated');
    }

    /**
     * ให้บริการไฟล์รูปโปรไฟล์ของผู้ใช้ปัจจุบันเท่านั้น
     */
    public function showProfilePhoto(string $filename)
    {
        $user = Auth::user();

        // กันดูรูปของคนอื่น
        if ($user->profile_photo !== $filename) {
            abort(403);
        }

        $path = storage_path('app/private/profile_photos/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    /**
     * แสดงหน้าแก้ไข Bio (1:1 User ↔ UserBio)
     */
    public function showBio()
    {
        $user = Auth::user();
        $bio  = $user->bio; // hasOne

        return view('profile.show-bio', compact('user', 'bio'));
    }

    /**
     * อัปเดตหรือสร้าง Bio ของผู้ใช้
     */
    public function updateBio(Request $request)
    {
        $user = Auth::user();
        $bio  = $user->bio;

        $validated = $request->validate([
            'bio' => ['required', 'string'],
        ]);

        if ($bio) {
            $bio->update(['bio' => $validated['bio']]);
        } else {
            $user->bio()->create(['bio' => $validated['bio']]);
        }

        return redirect()
            ->route('profile.show-bio') // หรือ ->route('profile.edit')
            ->with('status', 'Bio updated successfully!');
    }
}
