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
        Schema::create('admin_translates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Admin\Admin::class)->constrained()->onDelete('cascade');
            $table->string('locale', 10);
            $table->string('fname', 50)->nullable();
            $table->string('lname', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_translates');
    }
};
