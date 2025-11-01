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
        Schema::create('brand_image_translates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_image_id');
            $table->string('locale', 10);
            $table->string('title')->nullable();
            $table->timestamps();

            $table->foreign('brand_image_id')->references('id')->on('brand_images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_image_translates');
    }
};
