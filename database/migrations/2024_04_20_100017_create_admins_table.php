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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 40)->unique()->nullable();
            $table->string('fname',40);
            $table->string('lname',40);
            $table->string('email', 50)->nullable()->unique();
            $table->timestamp('email_validated_at')->nullable();
            $table->string('phone', 11)->unique();
            $table->timestamp('phone_validated_at')->nullable();
            $table->string('image_url')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('role',30)->default('admin');
            $table->boolean('is_active')->default(1);
            $table->string('password');
            $table->string('code', 10)->nullable();
            $table->tinyInteger('code_used')->default(0);
            $table->timestamp('code_created_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
