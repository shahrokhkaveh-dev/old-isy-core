<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('freezones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        $initialsData = [
            ['province_id' => 1, 'name' => 'منطقه آزاد تجاری-صنعتی اردبیل'],
            ['province_id' => 1, 'name' => 'منطقه ویژه اقتصادی نمین'],
            ['province_id' => 1, 'name' => 'منطقه ویژه اقتصادی نیر'],
            ['province_id' => 1, 'name' => 'منطقه ویژه اقتصادی مشگین شهر'],
            ['province_id' => 1, 'name' => 'منطقه ویژه اقتصادی گرمی'],
            ['province_id' => 1, 'name' => 'منطقه ویژه اقتصادی خلخال'],
            ['province_id' => 2, 'name' => 'منطقه ویژه اقتصادی شهرضا'],
            ['province_id' => 2, 'name' => 'منطقه ویژه اقتصادی کاشان'],
            ['province_id' => 2, 'name' => 'منطقه ویژه اقتصادی شاهین‌شهر'],
            ['province_id' => 2, 'name' => 'منطقه ویژه اقتصادی فریدن'],
            ['province_id' => 3, 'name' => 'منطقه ویژه اقتصادی پیام'],
            ['province_id' => 3, 'name' => 'منطقه ویژه اقتصادی ساوجبلاغ'],
            ['province_id' => 4, 'name' => 'منطقه آزاد تجاری-صنعتی ایلام'],
            ['province_id' => 5, 'name' => 'منطقه آزاد تجاری-صنعتی ارس'],
            ['province_id' => 5, 'name' => 'منطقه ویژه اقتصادی سهند مراغه'],
            ['province_id' => 5, 'name' => 'منطقه ویژه اقتصادی سهلان'],
            ['province_id' => 6, 'name' => 'منطقه آزاد تجاری-صنعتی ماکو'],
            ['province_id' => 6, 'name' => 'منطقه ویژه اقتصادی سلماس'],
            ['province_id' => 6, 'name' => 'منطقه ویژه اقتصادی سرو و ارومیه'],
            ['province_id' => 7, 'name' => 'منطقه آزاد تجاری-صنعتی بوشهر'],
            ['province_id' => 7, 'name' => 'منطقه ویژه اقتصادی بوشهر'],
            ['province_id' => 7, 'name' => 'منطقه ویژه اقتصادی انرژی پارس'],
            ['province_id' => 7, 'name' => 'منطقه ویژه اقتصادی شمال استان بوشهر'],
            ['province_id' => 8, 'name' => 'منطقه آزاد تجاری-صنعتی شهر فرودگاهی امام خمینی'],
            ['province_id' => 8, 'name' => 'منطقه ویژه اقتصادی پرند'],
            ['province_id' => 8, 'name' => 'منطقه ویژه اقتصادی ری'],
            ['province_id' => 11, 'name' => 'منطقه ویژه اقتصادی سبزوار'],
            ['province_id' => 11, 'name' => 'منطقه ویژه اقتصادی سرخس'],
            ['province_id' => 11, 'name' => 'منطقه ویژه اقتصادی دوغارون'],
            ['province_id' => 11, 'name' => 'منطقهمنطقه ویژه اقتصادی قوچان'],
            ['province_id' => 11, 'name' => 'منطقه ویژه اقتصادی کاشمر'],
            ['province_id' => 11, 'name' => 'منطقه ویژه اقتصادی خواف'],
            ['province_id' => 10, 'name' => 'منطقه ویژه اقتصادی بیرجند'],
            ['province_id' => 12, 'name' => 'منطقه ویژه اقتصادی بجنورد'],
            ['province_id' => 13, 'name' => 'منطقه آزاد تجاری-صنعتی اروند'],
            ['province_id' => 13, 'name' => 'منطقه ویژه اقتصادی بندر امام خمینی'],
            ['province_id' => 13, 'name' => 'منطقه ویژه اقتصادی پتروشیمی'],
            ['province_id' => 13, 'name' => 'منطقه ویژه اقتصادی مسجدسلیمان'],
            ['province_id' => 14, 'name' => 'منطقه ویژه اقتصادی زنجان'],
            ['province_id' => 15, 'name' => 'منطقه ویژه اقتصادی گرمسار'],
            ['province_id' => 16, 'name' => 'منطقه آزاد تجاری-صنعتی چابهار'],
            ['province_id' => 16, 'name' => 'منطقه آزاد تجاری-صنعتی سیستان'],
            ['province_id' => 16, 'name' => 'منطقه آزاد شهرستان زهک'],
            ['province_id' => 17, 'name' => 'منطقه ویژه اقتصادی شیراز'],
            ['province_id' => 17, 'name' => 'منطقه ویژه اقتصادی کازرون'],
            ['province_id' => 17, 'name' => 'منطقه ویژه اقتصادی فسا'],
            ['province_id' => 17, 'name' => 'منطقه ویژه اقتصادی پارسیان'],
            ['province_id' => 17, 'name' => 'منطقه ویژه اقتصادی لامرد'],
            ['province_id' => 18, 'name' => 'منطقه ویژه اقتصادی تاکستان'],
            ['province_id' => 19, 'name' => 'منطقه ویژه اقتصادی سلفچگان'],
            ['province_id' => 20, 'name' => 'منطقه آزاد تجاری-صنعتی بانه و مریوان'],
            ['province_id' => 20, 'name' => 'منطقه ویژه اقتصادی بانه'],
            ['province_id' => 21, 'name' => 'منطقه ویژه اقتصادی سیرجان'],
            ['province_id' => 21, 'name' => 'منطقه ویژه اقتصادی ارگ جدید'],
            ['province_id' => 21, 'name' => 'منطقه ویژه اقتصادی رفسنجان'],
            ['province_id' => 21, 'name' => 'منطقه ویژه اقتصادی جازموریان'],
            ['province_id' => 21, 'name' => 'منطقه ویژه اقتصادی شهربابک'],
            ['province_id' => 21, 'name' => 'منطقه ویژه اقتصادی گل گهر'],
            ['province_id' => 22, 'name' => 'منطقه آزاد تجاری-صنعتی قصرشیرین'],
            ['province_id' => 22, 'name' => 'منطقه ویژه اقتصادی اسلام‌آباد غرب'],
            ['province_id' => 23, 'name' => 'منطقه ویژه اقتصادی گچساران'],
            ['province_id' => 24, 'name' => 'منطقه آزاد تجاری-صنعتی اینچه‌برون'],
            ['province_id' => 24, 'name' => 'منطقه ویژه اقتصادی اترک'],
            ['province_id' => 25, 'name' => 'منطقه آزاد تجاری-صنعتی انزلی'],
            ['province_id' => 25, 'name' => 'منطقه ویژه اقتصادی بندر آستارا'],
            ['province_id' => 25, 'name' => 'منطقه ویژه اقتصادی صنعتی فومن ، صومعه سرا ، لاهیجان ،لنگرود'],
            ['province_id' => 25, 'name' => 'منطقه ویژه اقتصادی _ صنعتی گیلان رشت'],
            ['province_id' => 26, 'name' => 'منطقه ویژه اقتصادی ازنا'],
            ['province_id' => 26, 'name' => 'منطقه ویژه اقتصادی بروجرد'],
            ['province_id' => 26, 'name' => 'منطقه ویژه اقتصادی خرم‌آباد'],
            ['province_id' => 27, 'name' => 'منطقه آزاد تجاری-صنعتی مازندران'],
            ['province_id' => 27, 'name' => 'منطقه ویژه اقتصادی بندر امیرآباد'],
            ['province_id' => 27, 'name' => 'منطقه ویژه اقتصادی بندر فریدونکنار'],
            ['province_id' => 27, 'name' => 'منطقه ویژه اقتصادی بندر نوشهر'],
            ['province_id' => 27, 'name' => 'منطقه ویژه گردشگری نور و محمودآباد'],
            ['province_id' => 27, 'name' => 'منطقه ویژه اقتصادی آمل'],
            ['province_id' => 28, 'name' => 'منطقه ویژه اقتصادی ایرانیان'],
            ['province_id' => 28, 'name' => 'منطقه ویژه اقتصادی کاوه'],
            ['province_id' => 29, 'name' => 'منطقه آزاد تجاری-صنعتی قشم'],
            ['province_id' => 29, 'name' => 'منطقه آزاد تجاری-صنعتی کیش'],
            ['province_id' => 29, 'name' => 'منطقه ویژه اقتصادی بندر شهید رجایی'],
            ['province_id' => 29, 'name' => 'منطقه ویژه اقتصادی صنایع معدنی و فلزی خلیج فارس'],
            ['province_id' => 29, 'name' => 'منطقه ویژه اقتصادی کشتی سازی خلیج فارس'],
            ['province_id' => 29, 'name' => 'منطقه ویژه اقتصادی پارسیان'],
            ['province_id' => 29, 'name' => 'منطقه ویژه اقتصادی لاوان'],
            ['province_id' => 31, 'name' => 'منطقه ویژه اقتصادی فولاد اردکان'],
            ['province_id' => 31, 'name' => 'منطقه ویژه اقتصادی یزد'],
            ['province_id' => 31, 'name' => 'منطقه ویژه اقتصادی ابرکوه'],
            ['province_id' => 31, 'name' => 'منطقه ویژه اقتصادی بافق'],
            ['province_id' => 31, 'name' => 'منطقه ویژه اقتصادی میبد شهرستان میبد'],
            ['province_id' => 31, 'name' => 'منطقه ویژه اقتصادی مهریز. بندر خشک'],
            ['province_id' => 31, 'name' => 'منطقه ویژه اقتصادی شهرک بزرگ صنعتی یزد'],

        ];
        DB::table('freezones')->insert($initialsData);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freezones');
    }
};
