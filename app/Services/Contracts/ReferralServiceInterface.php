<?php
namespace App\Services\Contracts;

interface ReferralServiceInterface
{
    public function processReferral(string $referralCode, int $newUserId);
    public function awardReferrer(int $referralId);
}
