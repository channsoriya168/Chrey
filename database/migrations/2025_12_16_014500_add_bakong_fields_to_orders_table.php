<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('bakong_transaction_id')->nullable()->after('payment_status')->comment('Bakong Transaction ID');
            $table->text('bakong_qr_data')->nullable()->after('bakong_transaction_id')->comment('KHQR Code Data');
        });

        // Update payment_method enum to include 'khqr'
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('cash', 'card', 'bank_transfer', 'mobile_payment', 'khqr') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['bakong_transaction_id', 'bakong_qr_data']);
        });

        // Revert payment_method enum
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('cash', 'card', 'bank_transfer', 'mobile_payment') NULL");
    }
};
