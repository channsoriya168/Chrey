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
            $table->json('image_url')->nullable()->comment('រូបភាពផលិតផល (JSON)');
            $table->integer('quantity')->default(0)->comment('ចំនួនផលិតផល');
            $table->decimal('price', 10, 2)->default(0.00)->comment('តម្លៃផលិតផល');
            $table->decimal('discount_price', 10, 2)->nullable()->comment('តម្លៃបញ្ចុះតម្លៃ');
            $table->text('description')->nullable()->comment('ការពិពណ៌នាអំពីផលិតផល');
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->comment('កាតេហរីដែលផលិតផលនេះស្ថិតនៅក្នុង');
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
