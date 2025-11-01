<?php

namespace App\Lib\Translator\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleTranslate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Lib\Translator\GoogleTranslate::class;
    }
}
