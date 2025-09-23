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
     Schema::create('diary_entries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->date('date');                 // ✅ เพิ่มคอลัมน์วันที่
        $table->string('title')->nullable();  // จะเก็บ/ไม่เก็บก็ได้
        $table->text('content');              // ✅ บังคับกรอก (เอา nullable ออก)
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_entries');
    }
};
