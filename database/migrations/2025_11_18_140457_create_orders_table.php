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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique()->comment('លេខកូដការបញ្ជាទិញ');
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'refunded'])->default('pending')->comment('ស្ថានភាពការបញ្ជាទិញ');
            $table->string('bakong_transaction_id')->nullable()->comment('Bakong Transaction ID');
            $table->text('bakong_qr_data')->nullable()->comment('KHQR Code Data');
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->onDelete('set null')->comment('អាសយដ្ឋានដឹកជញ្ជូន');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
