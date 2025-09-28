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
    // This migration was created by mistake as 'date' column already exists
    // in the original diary_entries table creation migration.
    // Keeping this empty to avoid duplicate column errors.
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    // No changes needed as this migration doesn't actually add anything
}
};
