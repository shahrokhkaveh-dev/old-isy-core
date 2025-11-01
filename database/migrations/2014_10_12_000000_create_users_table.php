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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('phone',11)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->foreignId('province_id')->constrained('provinces')->onUpdate('cascade');
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade');
            $table->string('address',120)->nullable()->comment('نشانی پستی');
            $table->string('natonality_code',11)->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->boolean('is_foreign_account')->default(0);
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_branding')->default(0);
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
