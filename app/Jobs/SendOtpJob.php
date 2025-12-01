<?php

namespace App\Jobs;

use App\Mail\OtpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $email, private string $code, private string $codeType, private string $locale, private bool $freezone = false)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $from = $this->freezone ? __('email.freezone-title') : __('email.main-title');
        $result = Mail::to($this->email, $from)
            ->locale($this->locale)
            ->send(new OtpMail($this->code, $this->codeType, $this->freezone));
        //var_dump($result);
    }
}
