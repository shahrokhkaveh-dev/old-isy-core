<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Translation Source Language
    |--------------------------------------------------------------------------
    |
    | The source language from which translations will be made.
    |
    */
    'source_language' => env('TRANSLATION_SOURCE_LANGUAGE', 'fa-IR'),

    /*
    |--------------------------------------------------------------------------
    | Translation Target Languages
    |--------------------------------------------------------------------------
    |
    | An array of target languages to translate into.
    |
    */
    'target_languages' => explode(',', env('TRANSLATION_TARGET_LANGUAGES', 'fa-IR,en-US,ar-SA,tr-TR,ru-RU,zh-CN')),
];
