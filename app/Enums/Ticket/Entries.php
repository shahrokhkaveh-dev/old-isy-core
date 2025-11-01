<?php

namespace App\Enums\Ticket;

final class Entries
{
    public const STATUS = [
        1 => 'باز',
        2 => 'در حال بررسی',
        3 => 'پاسخ داده شده',
        4 => 'بسته شده',
    ];

    public const UUID_SEARCH_TYPE = 2;

    public const TITLE_SEARCH_TYPE = 1;
    public const ANSWERED_STATUS = 3;
}
