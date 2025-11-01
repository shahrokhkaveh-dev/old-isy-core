<?php

use Carbon\Carbon;
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
        Schema::create('plan_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
        $names = [
            'ثبت سفارش' ,
            'نمایه سازی کالا و محصولات' ,
            'استعلام' ,
            'استفاده از صنعت نامه' ,
            'دیوار صنعت' ,
            'امکان افزایش پیامک' ,
            'امکان شارژ کیف پول' ,
            'ثبت خبر و رویداد' ,
            'بارگذاری محصولات و نمایشگاه آنلاین' ,
            'درج پیام تبلیغاتی' ,
            'تولید محتوا' ,
            'بارگذاری ویدئو' ,
            'ترجمه به زبان انگلیسی و عربی' ,
            'پشتیبانی ' ,
            'مشاوره تخصصی '
        ];
        foreach($names as $name){
            DB::table('plan_attributes')->insert([
                'name'=> $name,
                'created_at'=> Carbon::now() ,
                'updated_at'=> Carbon::now()
            ]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_attributes');
    }
};
