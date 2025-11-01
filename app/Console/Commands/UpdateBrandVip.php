<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateBrandVip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brand:update-vip {mobiles*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update brand VIP expiration time and plan_id for given user mobiles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mobiles = $this->argument('mobiles');

        $users = User::whereIn('phone', $mobiles)->with('brand')->get();

        if($users->isEmpty()){
            $this->warn('No users found with provided mobile numbers.');
            return;
        }

        foreach ($users as $user) {
            $brand = $user->brand;

            if (!$brand) {
                $this->warn("No brand found for user {$user->mobile}");
                continue;
            }

            $brand->vip_expired_time = Carbon::now()->addMonths(3);
            $brand->plan_id = 1;
            $brand->save();

            $this->info("Brand {$brand->name} ID {$brand->id} updated for user {$user->mobile}");
        }

        $this->info('Done updating brands.');
    }
}
