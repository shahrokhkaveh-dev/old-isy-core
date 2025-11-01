<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $model = new User();
        parent::__construct($model);
    }

    public function findByReferralCode(string $code): User
    {
        return User::where('referral_code', $code)->first();
    }

    public function updateBrand(int $userId, int $brandId): void
    {
        $user = User::find($userId);
        if($user){
            $user->brand_id = $brandId;
            $user->save();
        }
    }
}
