<?php

use App\Models\Brand;
use App\Models\BrandType;
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
        Schema::create('brand_brand_type', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(BrandType::class)->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['brand_id', 'brand_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_brand_type');
    }
};
