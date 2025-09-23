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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();

            // ชื่อ tag เช่น "urgent", "school", "personal"
            // กำหนดความยาวไม่เกิน 100 ตัวอักษร
            $table->string('name', 100)->unique();

            // สำหรับการค้นหา tag ด้วยชื่อ
            $table->index('name', 'tags_name_index');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
