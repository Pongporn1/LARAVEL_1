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
        Schema::create('taggables', function (Blueprint $table) {
            // Primary key
            $table->id();

            // tag_id ชี้ไปที่ตาราง tags
            $table->foreignId('tag_id')
                  ->constrained() // อ้างอิงกับตาราง tags โดยอัตโนมัติ
                  ->cascadeOnDelete();

            // morphs() จะสร้าง taggable_id (BIGINT) + taggable_type (VARCHAR)
            $table->morphs('taggable');

            $table->timestamps();

            // ป้องกันการแนบ Tag เดิมซ้ำกับ record เดียวกัน
            $table->unique(
                ['tag_id', 'taggable_type', 'taggable_id'],
                'taggables_unique'
            );

            // เพิ่ม index สำหรับการ query morph relations เร็วขึ้น
            $table->index(['taggable_id', 'taggable_type'], 'taggable_lookup_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggables');
    }
};
