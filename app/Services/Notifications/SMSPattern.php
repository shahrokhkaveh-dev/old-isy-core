<?php

namespace App\Services\Notifications;

use App\Jobs\SMSInquiry;
use App\Jobs\SMSLetter;
use App\Jobs\SMSNotification;


class SMSPattern extends SMS
{
    static public function sendOtp($to, $otp)
    {
        if(getMode() == 'freezone'){
            SMSNotification::dispatch($to, $otp, 355375)->onQueue('otpSMS');
        }else{
            SMSNotification::dispatch($to, $otp, 340070)->onQueue('otpSMS');
        }
    }

    static public function sendInquery($to, $brandName)
    {
        if(getMode() == 'freezone'){
            SMSInquiry::dispatch($to, $brandName, '355376')->onQueue('notificationSMS');
        }else{
            SMSInquiry::dispatch($to, $brandName, '340071')->onQueue('notificationSMS');
        }
    }

    static public function sendMail($to, $brandName, $title)
    {
        if(getMode() == 'freezone'){
            SMSLetter::dispatch($to, $brandName, $title, 355378)->onQueue('notificationSMS');
        }else{
            SMSLetter::dispatch($to, $brandName, $title, 340072)->onQueue('notificationSMS');
        }
    }

    static public function sendInqueryResponse($to, $brandName)
    {
        if(getMode() == 'freezone'){
            SMSInquiry::dispatch($to, $brandName, '355379')->onQueue('notificationSMS');
        }else{
            SMSInquiry::dispatch($to, $brandName, '345704')->onQueue('notificationSMS');
        }
    }
}
