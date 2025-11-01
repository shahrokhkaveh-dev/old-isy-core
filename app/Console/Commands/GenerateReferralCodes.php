<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateReferralCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:generate-referral-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate referral codes for all users who do not have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereNull('referral_code')->get();

        if ($users->isEmpty()) {
            $this->info('No users found without a referral code.');
            return 0;
        }

        $count = 0;
        foreach ($users as $user) {
            $user->referral_code = $this->generateUniqueReferralCode();
            $user->save();
            $count++;
            $this->info("Referral code generated for user ID {$user->id}: {$user->referral_code}");
        }

        $this->info("Successfully generated referral codes for {$count} users.");
        return 0;
    }

    /**
     * Generate a unique referral code.
     *
     * @param int $length
     * @return string
     */
    private function generateUniqueReferralCode($length = 8)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}
