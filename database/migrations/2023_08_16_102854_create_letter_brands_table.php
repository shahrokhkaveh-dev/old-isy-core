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
        Schema::create('letter_brands', function (Blueprint $table) {
            $table->foreignId('letter_id')->constrained('letters');
            $table->foreignId('brand_id')->constrained('brands');
            $table->tinyInteger('status')->default(1);
            $table->boolean('seen')->default(false);
            $table->primary(['letter_id' , 'brand_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_brands');
    }
};
