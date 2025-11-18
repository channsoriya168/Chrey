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
            $table->decimal('subtotal', 10, 2)->comment('សរុបរងតម្លៃផលិតផល');
            $table->decimal('tax', 10, 2)->default(0)->comment('ពន្ធ');
            $table->decimal('shipping_cost', 10, 2)->default(0)->comment('ថ្លៃដឹកជញ្ជូន');
            $table->decimal('discount', 10, 2)->default(0)->comment('បញ្ចុះតម្លៃ');
            $table->decimal('total_amount', 10, 2)->comment('តម្លៃសរុប');
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'mobile_payment'])->nullable()->comment('វិធីសាស្ត្របង់ប្រាក់');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->comment('ស្ថានភាពបង់ប្រាក់');
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->onDelete('set null')->comment('អាសយដ្ឋានដឹកជញ្ជូន');
            $table->foreignId('billing_address_id')->nullable()->constrained('addresses')->onDelete('set null')->comment('អាសយដ្ឋានវិក្កយបត្រ');
            $table->text('notes')->nullable()->comment('កំណត់ចំណាំ');
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
