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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->unique()->nullable()->comment('លេខកូដប្រតិបត្តិការ');
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'mobile_payment'])->comment('វិធីសាស្ត្របង់ប្រាក់');
            $table->decimal('amount', 10, 2)->comment('ចំនួនទឹកប្រាក់');
            $table->string('currency', 3)->default('USD')->comment('រូបិយប័ណ្ណ');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending')->comment('ស្ថានភាពបង់ប្រាក់');
            $table->timestamp('payment_date')->nullable()->comment('កាលបរិច្ឆេទបង់ប្រាក់');
            $table->string('payment_gateway')->nullable()->comment('ច្រកបង់ប្រាក់');
            $table->text('notes')->nullable()->comment('កំណត់ចំណាំ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
