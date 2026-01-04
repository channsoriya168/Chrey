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
            $table->string('phone')->comment('លេខទូរស័ព្ទ');
            $table->string('province')->comment('ខេត្ត/ទីក្រុង');
            $table->string('district')->nullable()->comment('ស្រុក/ខណ្ឌ');
            $table->string('commune')->nullable()->comment('ឃុំ/សង្កាត់');
            $table->string('village')->nullable()->comment('ភូមិ/សង្កាត់');
            $table->string('note')->nullable()->comment('កំណត់ចំណាំ');
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
