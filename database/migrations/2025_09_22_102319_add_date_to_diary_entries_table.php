<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('diary_entries', function (Blueprint $table) {
        // เพิ่มคอลัมน์ date ถัดจาก user_id
        $table->date('date')->after('user_id')->nullable(); // ทำเป็น nullable ไว้ก่อนเพื่อไม่ชนข้อมูลเก่า
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('diary_entries', function (Blueprint $table) {
        $table->dropColumn('date');
    });
}
};
