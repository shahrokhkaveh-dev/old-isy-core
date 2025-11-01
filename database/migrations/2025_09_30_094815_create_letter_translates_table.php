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
        Schema::create('letter_translates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Letter::class)->constrained()->onDelete('cascade');
            $table->string('locale', 10);
            $table->string('author_name')->nullable();
            $table->string('reciver_name')->nullable();
            $table->string('name')->nullable();
            $table->string('group_name')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_translates');
    }
};
