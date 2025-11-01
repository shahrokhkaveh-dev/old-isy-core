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
        Schema::create('province_translates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Province::class)->constrained()->onDelete('cascade');
            $table->string('locale', 10);
            $table->string('name', 40)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('province_translates');
    }
};
