<?php

namespace App\Services\Notifications;

use App\Jobs\SendFirebaseNotification;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;
    protected Auth $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $this->messaging = $factory->createMessaging();
        $this->auth = (new Factory)
            ->withServiceAccount(config('services.firebase.credentials'))
            ->createAuth();
    }

    public function sendLetterNotificationToUsers($brand, $content)
    {
        $users = $brand->users;
        foreach ($users as $user) {
            if (!$user->access(3)) {
                continue;
            }
            $firebaseToken = $user->firebaseToken;
            if (!is_null($firebaseToken)) {
                $brandLogo = $brand->logo_path ? asset($brand->logo_path) : asset('assets/images/letterLogo.png');
                SendFirebaseNotification::dispatch($firebaseToken->token, 'صنعت یار ایران', $content, $brandLogo)->onQueue('notification');
            }
        }
    }

    public function sendInquiryNotificationToUser($sender, $receiver){
        $firebaseToken = $receiver->firebaseToken;
        if (!is_null($firebaseToken)) {
            $userAvatar = $sender->brand ? asset($sender->brand->logo_path) : asset('assets/images/user.png');
            SendFirebaseNotification::dispatch($firebaseToken->token, 'استعلام', 'شما درخواست استعلام جدید دارید', $userAvatar)->onQueue('notification');
        }
    }

    public function verifyIdToken(string $idToken): ?string
    {
        $verifiedIdToken = $this->auth->verifyIdToken($idToken);
        dd($verifiedIdToken);
        try{
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            return $verifiedIdToken->claims()->get('sub');
        }catch (FailedToVerifyToken $e){
            return false;
        }
    }
}
