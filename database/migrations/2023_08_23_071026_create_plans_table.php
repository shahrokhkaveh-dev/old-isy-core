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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gradient_from');
            $table->string('gradient_to');
            $table->unsignedInteger('period');
            $table->bigInteger('price')->default(0);
            $table->bigInteger('showPrice')->default(0);
            $table->string('showUnit');
            $table->tinyInteger('discount_type')->comment('0->percent and 1->const')->nullable();
            $table->integer('discont_percenet')->nullable();
            $table->bigInteger('discont_const')->nullable();
            $table->bigInteger('max_discont_percenet')->nullable();
            $table->timestamp('discount_expired_time')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        DB::table('plans')->insert([
            'name' => 'اشتراک طلایی',
            'gradient_from' => '#053272',
            'gradient_to' => '#E5CF02',
            'period' => 12,
            'price' => 150000000,
            'showPrice' => 15,
            'showUnit' => 'میلیون تومان',
        ]);
        DB::table('plans')->insert([
            'name' => 'اشتراک نقره‌ای',
            'gradient_from' => '#053272',
            'gradient_to' => '#626051',
            'period' => 12,
            'price' => 70000000,
            'showPrice' => 7,
            'showUnit' => 'میلیون تومان',
        ]);
        DB::table('plans')->insert([
            'name' => 'اشتراک برنزی',
            'gradient_from' => '#053272',
            'gradient_to' => '#EE8D21',
            'period' => 6,
            'price' => 40000000,
            'showPrice' => 4,
            'showUnit' => 'میلیون تومان',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
