<?php

namespace App\Services\Notifications;

use App\Jobs\SendOtpJob;

class EmailService
{
    public static function sendOtp(string $email, string $code, string $codeType, string $locale, bool $freezone = false): void
    {
        SendOtpJob::dispatch($email, $code, $codeType, $locale, $freezone)->onQueue('otpSMS');;
    }
}
