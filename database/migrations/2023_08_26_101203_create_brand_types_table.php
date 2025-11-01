<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brand_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
        DB::table('brand_types')->insert([
            'name'=>'صنعت‌گران'
        ]);
        DB::table('brand_types')->insert([
            'name'=>'پیمانکاران'
        ]);
        DB::table('brand_types')->insert([
            'name'=>'بازرگانان'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_types');
    }
};
