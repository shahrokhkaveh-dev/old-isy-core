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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained('provinces')->onUpdate('cascade');
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade');
            $table->string('name');
            $table->string('nationality_code',11)->unique()->comment('شناسه ملی');
            $table->string('economic_code',12)->nullable()->comment('کد اقتصادی');
            $table->string('register_code',6)->nullable()->comment('شماره ثبت');
            $table->string('license_number',15)->nullable()->comment('شماره مجوز');
            $table->string('phone_number',11)->nullable()->comment('شماره تلفن');
            $table->string('post_code',10)->nullable()->comment('کد پستی');
            $table->string('address',120)->nullable()->comment('نشانی پستی');
            $table->string('logo_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->tinyInteger('status')->default(1);
            $table->string('slug')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
