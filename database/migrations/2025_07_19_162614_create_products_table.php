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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->comment('ស្លាកផលិតផល');
            $table->string('code')->unique()->comment('លេខកូដផលិតផល');
            $table->string('name')->comment('ឈ្មោះផលិតផល');
            $table->text('description')->nullable()->comment('ការពិពណ៌នាអំពីផលិតផល');
            $table->integer('stock')->default(0)->comment('ចំនួនផលិតផល');
            $table->enum('size', ['តូច', 'មធ្យម', 'ធំ'])->default('មធ្យម')->comment('ទំហំផលិតផល');
            $table->decimal('price', 10, 2)->default(0.00)->comment('តម្លៃផលិតផល');
            $table->json('image_url')->nullable()->comment('រូបភាពផលិតផល (JSON)');
            $table->decimal('discount_price_percent', 5, 2)->nullable()->comment('ភាគរយបញ្ចុះតម្លៃ');
            $table->decimal('discount_price', 10, 2)->storedAs('price - (price * COALESCE(discount_price_percent, 0) / 100)')->comment('តម្លៃបញ្ចុះតម្លៃ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
