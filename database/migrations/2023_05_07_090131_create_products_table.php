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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ename');
            $table->text('image');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('warranty')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('unit',25)->nullable();
            $table->float('score')->default(0);
            $table->integer('votes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
