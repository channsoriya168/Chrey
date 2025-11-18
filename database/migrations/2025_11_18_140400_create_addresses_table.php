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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['shipping', 'billing', 'both'])->default('both')->comment('ប្រភេទអាសយដ្ឋាន');
            $table->string('full_name')->comment('ឈ្មោះពេញ');
            $table->string('phone')->comment('លេខទូរស័ព្ទ');
            $table->text('address_line1')->comment('អាសយដ្ឋានទី១');
            $table->text('address_line2')->nullable()->comment('អាសយដ្ឋានទី២');
            $table->string('city')->comment('ក្រុង/ខេត្ត');
            $table->string('state_province')->nullable()->comment('រដ្ឋ/ខេត្ត');
            $table->string('postal_code')->nullable()->comment('លេខកូដប្រៃសណីយ៍');
            $table->string('country')->default('Cambodia')->comment('ប្រទេស');
            $table->boolean('is_default')->default(false)->comment('អាសយដ្ឋានលំនាំដើម');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
