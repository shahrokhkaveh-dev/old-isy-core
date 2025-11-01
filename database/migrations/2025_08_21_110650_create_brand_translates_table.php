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
        Schema::create('brand_translates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Brand::class)->constrained()->onDelete('cascade');
            $table->string('locale', 10);
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('managment_name')->nullable();
            $table->string('managment_position')->nullable();
            $table->string('name')->nullable();
            $table->string('plan_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_translates');
    }
};
