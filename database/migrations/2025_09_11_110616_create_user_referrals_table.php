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
        Schema::create('user_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referred_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referrer_brand_id')->nullable()->constrained('brands')->cascadeOnDelete();
            $table->foreignId('referred_brand_id')->nullable()->constrained('brands')->cascadeOnDelete();

            $table->timestamp('claimed_at')->nullable();
            $table->timestamps();

            $table->index(['referrer_user_id', 'referred_user_id']);
            $table->index(['referrer_brand_id', 'referred_brand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_referrals');
    }
};
