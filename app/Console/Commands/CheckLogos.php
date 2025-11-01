<?php

namespace App\Console\Commands;

use App\Models\Brand;
use Illuminate\Console\Command;

class CheckLogos extends Command
{
    protected $signature = 'logos:check';
    protected $description = 'Check if PNG files exist in the public/uploads/logos directory and update the Brand model';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $brands = Brand::all();

        foreach ($brands as $brand) {
            $logoPath = public_path($brand->logo_path);

            if (!file_exists($logoPath)) {
                $brand->logo_path = null;
                $brand->save();

                $this->info("Updated Brand ID {$brand->id}: logo_path set to null.");
            }
        }

        $this->info('Logo check completed.');
        return 0;
    }
}
