<?php
namespace App\Services;

use App\Models\UserReferral;
use App\Repositories\UserRepository;
use App\Services\Contracts\ReferralServiceInterface;
use App\Exceptions\InvalidReferralCodeException;
use App\Models\User;

class ReferralService implements ReferralServiceInterface
{
    protected UserRepository $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function applyRefferalCode(int $userId, string $referralCode): UserReferral|bool
    {
        $reffered = User::findOrFail($userId);
        $referrer = User::where('referral_code', $referralCode)->first();

        if(!$referrer || !$reffered){
            return false;
        }

        return UserReferral::create([
            'referrer_user_id' => $referrer->id,
            'referred_user_id' => $reffered->id,
            'referrer_brand_id' => $referrer->brand_id,
            'referred_brand_id' => $reffered->brand_id,
            'claimed_at' => now()
        ]);

        // return true;
    }

    public function processReferral(string $referralCode, int $newUserId)
    {
        $referrer = $this->userRepo->findByReferralCode($referralCode);
        $reffered = $this->userRepo->getRecordById($newUserId);
        if(!$referrer || $reffered){
            throw new InvalidReferralCodeException();
        }

        UserReferral::create([
            'referrer_user_id' => $referrer->id,
            'referred_user_id' => $reffered->id,
            'referrer_brand_id' => $referrer->brand_id,
            'referred_brand_id' => $reffered->brand_id,
            'claimed_at' => now()
        ]);
    }

    public function awardReferrer(int $referralId)
    {

    }
}
