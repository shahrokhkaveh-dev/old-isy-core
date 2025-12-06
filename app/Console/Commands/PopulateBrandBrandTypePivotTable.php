<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PopulateBrandBrandTypePivotTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-brand-brand-type-pivot {--force : Overwrite existing data without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates the brand_brand_type pivot table from existing brand data in 1000 record chunks.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if the pivot table exists.
        if (!Schema::hasTable('brand_brand_type')) {
            $this->error('The `brand_brand_type` table does not exist. Please run your migrations first.');
            return 1;
        }

        // Check if the table is already populated.
        if (!$this->option('force') && DB::table('brand_brand_type')->count() > 0) {
            $this->warn('The `brand_brand_type` table is not empty.');
            if (!$this->confirm('Do you want to continue and potentially create duplicate records?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('Starting to populate the `brand_brand_type` pivot table...');
        $this->line('Processing brands in chunks of 1000...');

        $processedCount = 0;
        $skippedCount = 0;

        // Select only brands that have a brand type and process them in chunks.
        DB::table('brands')
            ->select('id', 'type')
            ->whereNotNull('type')
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->chunk(1000, function ($brands) use (&$processedCount, &$skippedCount) {

                $insertData = [];
                foreach ($brands as $brand) {
                    // Check for existing relationship to avoid duplicates.
                    // This is for safety, in case the command is run again.
                    $exists = DB::table('brand_brand_type')
                        ->where('brand_id', $brand->id)
                        ->where('brand_type_id', $brand->type)
                        ->exists();

                    if (!$exists) {
                        $insertData[] = [
                            'brand_id' => $brand->id,
                            'brand_type_id' => $brand->type,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    } else {
                        $skippedCount++;
                    }
                }

                // Bulk insert the data.
                if (!empty($insertData)) {
                    DB::table('brand_brand_type')->insert($insertData);
                    $processedCount += count($insertData);
                    $this->line("- Inserted " . count($insertData) . " new records.");
                }
            });

        $this->info('------------------------------------------');
        $this->info('Operation completed successfully!');
        $this->info("Total new records inserted: {$processedCount}");
        if ($skippedCount > 0) {
            $this->warn("Total duplicate records skipped: {$skippedCount}");
        }

        return 0;
    }
}
