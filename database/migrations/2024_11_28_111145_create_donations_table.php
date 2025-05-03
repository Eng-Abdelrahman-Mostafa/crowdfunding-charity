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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('users')->nullOnDelete();
            $table->foreignId('campaign_id')->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->boolean('donate_anonymously')->default(false);
            $table->string('currency', 3);
            $table->enum('payment_status', ['pending', 'success', 'failed']);
            $table->string('payment_method')->default('online');
            $table->string('payment_with')->nullable()
            ->comment('payment gateway, bank, bkash, rocket etc');
            $table->string('invoice_id')->nullable();
            $table->string('invoice_key')->nullable();
            $table->string('invoice_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
