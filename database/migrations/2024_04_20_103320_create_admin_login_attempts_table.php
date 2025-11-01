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
        Schema::create('admin_login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('username', 40)->nullable();
            $table->boolean('status')->default(0)->comment('0 = failed , 1 = success'); // 0 = failed , 1 = success
            $table->string('referrer')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('ip', 20);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_login_attempts');
    }
};
