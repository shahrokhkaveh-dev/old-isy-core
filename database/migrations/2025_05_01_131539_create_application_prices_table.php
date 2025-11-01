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
        Schema::create('application_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('brandId')->nullable()->constrained('brands')->onDelete('cascade');
            $table->foreignId('planId')->nullable()->constrained('plans')->onDelete('cascade');
            $table->string('orderId')->nullable();
            $table->string('packageName')->nullable();
            $table->string('productId')->nullable();
            $table->string('purchaseTime')->nullable();
            $table->string('purchaseState')->nullable();
            $table->string('developerPayload')->nullable();
            $table->string('purchaseToken')->nullable();
            $table->enum('status',['failed','success'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_prices');
    }
};
