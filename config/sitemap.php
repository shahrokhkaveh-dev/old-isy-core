<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sitemap Configurations
    |--------------------------------------------------------------------------
    */
    'sites' => [
        'main' => [
            'base_url' => env('MAIN_SITEMAP_BASE_URL', env('APP_URL')),
            // مسیر فایل ایندکس اصلی
            'index_path' => env('MAIN_SITEMAP_INDEX_PATH', 'sitemap.xml'),
            // پوشه‌ای که فایل‌های sitemap فرزند در آن ذخیره می‌شوند
            'files_path' => env('MAIN_SITEMAP_FILES_PATH', 'sitemaps/'),
        ],
        'freezone' => [
            'base_url' => env('FREEZONE_SITEMAP_BASE_URL', env('APP_URL')),
            'index_path' => env('FREEZONE_SITEMAP_INDEX_PATH', 'sitemap.xml'),
            'files_path' => env('FREEZONE_SITEMAP_FILES_PATH', 'sitemaps/'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap Settings
    |--------------------------------------------------------------------------
    */
    'locales' => ['fa', 'en', 'ar', 'tr', 'ru', 'zh'],
    'max_urls' => 50000, // حداکثر تعداد URL در هر فایل
];
