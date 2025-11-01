<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class SendFirebaseNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deviceToken;
    protected $title;
    protected $body;
    protected $imageUrl;
    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($deviceToken, $title, $body, $imageUrl, $data = [])
    {
        $this->deviceToken = $deviceToken;
        $this->title = $title;
        $this->body = $body;
        $this->imageUrl = $imageUrl;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notification = Notification::create($this->title, $this->body)->withImageUrl($this->imageUrl);
        $message = CloudMessage::withTarget('token', $this->deviceToken)
            ->withNotification($notification)
            ->withData($this->data);

        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $messaging = $factory->createMessaging();

        try {
            $messaging->send($message);
        } catch (MessagingException|FirebaseException $e) {

        }
    }
}
