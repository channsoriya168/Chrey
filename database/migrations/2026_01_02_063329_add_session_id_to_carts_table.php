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
        Schema::table('carts', function (Blueprint $table) {
            // Make user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            // Add session_id for guest carts
            $table->string('session_id')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Revert user_id to not nullable
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            // Drop session_id column
            $table->dropColumn('session_id');
        });
    }
};
