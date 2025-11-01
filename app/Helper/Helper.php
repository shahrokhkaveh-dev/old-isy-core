<?php

use App\Models\Category;

require_once('coreArrays.php');
require_once('constance.php');
function random_lenght($randomNumberLength = 4)
{
    $min = 1;
    $max = 9;
    for ($i = 1; $i < $randomNumberLength; $i++) {
        $min *= 10;
        $max *= 10;
        $max += 9;
    }
    $random = rand($min, $max);
    return $random;
}

function  getCode($length = 4)
{
    $code = time() . random_lenght($length);
    return $code;
}


function getCategoriesWithSubcategories($parentId = null): array
{
    $categories = Category::where('parent_id', $parentId)
        ->where('deleted_at', null) // فیلتر دسته‌های حذف نشده
        ->get(['id', 'name']); // فقط id و name را می‌گیریم

    $result = [];
    foreach ($categories as $category) {
        $subcategory = getCategoriesWithSubcategories($category->id); // فراخوانی بازگشتی برای زیر دسته‌ها
        $result[] = [
            'id' => $category->id,
            'name' => $category->name,
            'subcategories' => $subcategory
        ];
    }

    return $result;
}

function getMode(): string
{
    return app()->bound('request_mode') ? app('request_mode') : 'global';
}

if (!function_exists('timeAgo')) {
    function timeAgo($date)
    {
        if (app()->getLocale() === 'fa') {
            return Morilog\Jalali\Jalalian::forge($date)->ago();   // شمسی + فارسی
        }

        // پیش‌فرض: هر زبان دیگه
        Carbon\Carbon::setLocale(app()->getLocale());      // مثلا en, ar, tr ...
        return Carbon\Carbon::parse($date)->diffForHumans();
    }
}
if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'Y/m/d')
    {
        if (app()->getLocale() === 'fa') {
            return jdate($date)->format($format);   // شمسی
        }

        return \Carbon\Carbon::parse($date)->format($format); // میلادی
    }
}