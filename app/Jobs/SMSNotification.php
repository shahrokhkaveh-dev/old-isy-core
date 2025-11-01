<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SMSNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to;
    private $otp;
    private $bodyId;

    /**
     * Create a new job instance.
     */
    public function __construct($to, $otp, $bodyId = 340070)
    {
        $this->to = $to;
        $this->otp = $otp;
        $this->bodyId = $bodyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $username = '09120220862';
        $password = 'Q$EA4';
        $bodyId= $this->bodyId;

        $data = array('username' => $username, 'password' => $password,'text' => $this->otp,'to' =>$this->to ,"bodyId"=>$bodyId);
        $post_data = http_build_query($data);
        $handle = curl_init('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'content-type' => 'application/x-www-form-urlencoded'
        ));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_exec($handle);
    }
}
