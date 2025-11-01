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
        Schema::create('brand_type_translates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_type_id');
            $table->string('locale', 10);
            $table->string('name')->nullable();
            $table->timestamps();

            $table->foreign('brand_type_id')->references('id')->on('brand_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_type_translates');
    }
};
