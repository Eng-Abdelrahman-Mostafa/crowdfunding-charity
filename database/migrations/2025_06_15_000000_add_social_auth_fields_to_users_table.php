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
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_id')->nullable()->after('phone');
            $table->string('social_type')->nullable()->after('social_id');
            $table->string('social_avatar')->nullable()->after('social_type');
            // Make password nullable for social auth users
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['social_id', 'social_type', 'social_avatar']);
            // This won't work directly with SQLite, would need a more complex approach
            // $table->string('password')->nullable(false)->change();
        });
    }
};
