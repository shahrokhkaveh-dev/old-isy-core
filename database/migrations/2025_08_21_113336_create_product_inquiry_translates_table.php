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
        Schema::create('product_inquiry_translates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ProductInquery::class, 'product_inquiry_id')
                ->constrained(table: 'product_inquiries', indexName: 'product_inquery_id_translate_foreig')
                ->onDelete('cascade');
            $table->string('locale', 10);
            $table->string('description')->nullable();
            $table->text('response_description')->nullable();
            $table->string('unit', 40)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inquiry_translates');
    }
};
