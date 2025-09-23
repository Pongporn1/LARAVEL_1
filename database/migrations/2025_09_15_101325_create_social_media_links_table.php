<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('social_media_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('platform_name', 50);
            $table->string('url', 255);
            $table->unique(['user_id', 'platform_name']); // กันซ้ำต่อผู้ใช้
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media_links');
    }
};
