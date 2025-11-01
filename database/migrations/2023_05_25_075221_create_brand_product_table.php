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
        Schema::create('brand_product', function (Blueprint $table) {
            $table->foreignId('brand_id')->constrained('brands')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade');
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_product');
    }
};
