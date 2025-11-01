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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('ip');
            $table->string('mac')->nullable();
            $table->text('agent');
            $table->text('controller')->nullable();
            $table->string('method')->nullable();
            $table->text('input')->nullable();
            $table->text('output')->nullable();
            $table->string('route')->nullable();
            $table->string('http_method')->nullable();
            $table->string('referer')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
