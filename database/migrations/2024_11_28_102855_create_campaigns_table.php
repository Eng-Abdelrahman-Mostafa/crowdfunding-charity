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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('address');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->decimal('goal_amount', 10, 2);
            $table->decimal('collected_amount', 10, 2)->default(0);
            $table->enum('donation_type', ['open', 'share']);
            $table->decimal('share_amount', 10, 2)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('association_id')->constrained();
            $table->foreignId('donation_category_id')->constrained();
            $table->foreignId('created_by')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
