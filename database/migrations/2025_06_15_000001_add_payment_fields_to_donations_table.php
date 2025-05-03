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
        Schema::table('donations', function (Blueprint $table) {
            // Add payment_data JSON column to store payment gateway response
            $table->json('payment_data')->nullable()->after('invoice_url');
            
            // Add payment_reference to store the payment reference number from gateway
            $table->string('payment_reference')->nullable()->after('payment_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['payment_data', 'payment_reference']);
        });
    }
};
