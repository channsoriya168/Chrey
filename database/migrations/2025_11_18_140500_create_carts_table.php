<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable()->comment('For guest carts before login');
            $table->enum('status', ['active', 'checked_out'])
                ->default('active')
                ->comment('active: User is shopping | checked_out: Order placed & paid');

            // Link to address for checkout
            $table->foreignId('pending_address_id')->nullable()->constrained('addresses')->onDelete('set null');

            // Payment tracking
            $table->string('md5')->nullable()->unique();

            $table->timestamps();

            // Indexes for finding carts
            $table->index(['user_id', 'status']);
            $table->index(['session_id', 'status']);
            $table->index('md5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
