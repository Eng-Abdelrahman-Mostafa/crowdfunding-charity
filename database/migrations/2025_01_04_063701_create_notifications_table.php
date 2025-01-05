<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data'); // Changed from jsonb to text
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index(['notifiable_id', 'notifiable_type']);
        });

        // Create an index for JSON querying
        DB::statement('CREATE INDEX notifications_data_format_idx ON notifications ((data::json->>\'format\'))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the JSON index first
        DB::statement('DROP INDEX IF EXISTS notifications_data_format_idx');

        Schema::dropIfExists('notifications');
    }
};
