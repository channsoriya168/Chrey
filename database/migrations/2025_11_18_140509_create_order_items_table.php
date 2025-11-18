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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name')->comment('ឈ្មោះផលិតផលនៅពេលទិញ');
            $table->string('product_code')->comment('លេខកូដផលិតផលនៅពេលទិញ');
            $table->integer('quantity')->comment('ចំនួន');
            $table->decimal('unit_price', 10, 2)->comment('តម្លៃឯកតា');
            $table->decimal('subtotal', 10, 2)->comment('សរុបរង');
            $table->decimal('discount', 10, 2)->default(0)->comment('បញ្ចុះតម្លៃ');
            $table->decimal('total', 10, 2)->comment('តម្លៃសរុប');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
