<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaLink;
use App\Http\Requests\SocialMediaLinkRequest; // ไฟล์ validate ที่คุณมีอยู่แล้ว
use Illuminate\Support\Facades\Auth;

class SocialMediaLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(SocialMediaLink::class, 'social_link');
    }

    /**
     * แสดงรายการลิงก์ทั้งหมดของผู้ใช้
     */
    public function index()
    {
        $links = Auth::user()->socialMediaLinks()->latest()->paginate(10);
        return view('social_links.index', compact('links'));
    }

    /**
     * แสดงฟอร์มเพิ่มลิงก์ใหม่
     */
    public function create()
    {
        return view('social_links.create');
    }

    /**
     * บันทึกลิงก์ใหม่ลงฐานข้อมูล
     */
    public function store(SocialMediaLinkRequest $request)
    {
        $request->user()->socialMediaLinks()->create($request->validated());

        return redirect()
            ->route('social-links.index')
            ->with('success', 'เพิ่ม Social Media Link เรียบร้อยแล้ว');
    }

    /**
     * แสดงฟอร์มแก้ไขลิงก์
     */
    public function edit(SocialMediaLink $social_link)
    {
        return view('social_links.edit', compact('social_link'));
    }

    /**
     * อัปเดตข้อมูลลิงก์
     */
    public function update(SocialMediaLinkRequest $request, SocialMediaLink $social_link)
    {
        $social_link->update($request->validated());

        return redirect()
            ->route('social-links.index')
            ->with('success', 'อัปเดต Social Media Link เรียบร้อยแล้ว');
    }

    /**
     * ลบลิงก์ออก
     */
    public function destroy(SocialMediaLink $social_link)
    {
        $social_link->delete();

        return redirect()
            ->route('social-links.index')
            ->with('success', 'ลบ Social Media Link เรียบร้อยแล้ว');
    }
}
