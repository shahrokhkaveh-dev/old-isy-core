<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PopulateBrandCategoryPivotTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-brand-category-pivot {--force : Overwrite existing data without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates the brand_category pivot table from existing brand data in 1000 record chunks.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if the pivot table exists.
        if (!Schema::hasTable('brand_category')) {
            $this->error('The `brand_category` table does not exist. Please run your migrations first.');
            return 1;
        }

        // Check if the table is already populated.
        if (!$this->option('force') && DB::table('brand_category')->count() > 0) {
            $this->warn('The `brand_category` table is not empty.');
            if (!$this->confirm('Do you want to continue and potentially create duplicate records?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('Starting to populate the `brand_category` pivot table...');
        $this->line('Processing brands in chunks of 1000...');

        $processedCount = 0;
        $skippedCount = 0;
        $invalidCategoryCount = 0;

        // Get all valid category IDs from the categories table
        $validCategoryIds = DB::table('categories')
            ->whereNull('deleted_at')
            ->pluck('id')
            ->toArray();

        // Select only brands that have a category and process them in chunks.
        DB::table('brands')
            ->select('id', 'category_id')
            ->whereNotNull('category_id')
            ->whereIn('category_id', $validCategoryIds)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->chunk(1000, function ($brands) use (&$processedCount, &$skippedCount) {

                $insertData = [];
                foreach ($brands as $brand) {
                    // Check for existing relationship to avoid duplicates.
                    // This is for safety, in case the command is run again.
                    $exists = DB::table('brand_category')
                        ->where('brand_id', $brand->id)
                        ->where('category_id', $brand->category_id)
                        ->exists();

                    if (!$exists) {
                        $insertData[] = [
                            'brand_id' => $brand->id,
                            'category_id' => $brand->category_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    } else {
                        $skippedCount++;
                    }
                }

                // Bulk insert the data.
                if (!empty($insertData)) {
                    DB::table('brand_category')->insert($insertData);
                    $processedCount += count($insertData);
                    $this->line("- Inserted " . count($insertData) . " new records.");
                }
            });

        // Count brands with invalid category IDs
        $invalidCategoryCount = DB::table('brands')
            ->whereNotNull('category_id')
            ->whereNull('deleted_at')
            ->whereNotIn('category_id', $validCategoryIds)
            ->count();

        $this->info('------------------------------------------');
        $this->info('Operation completed successfully!');
        $this->info("Total new records inserted: {$processedCount}");
        if ($skippedCount > 0) {
            $this->warn("Total duplicate records skipped: {$skippedCount}");
        }
        if ($invalidCategoryCount > 0) {
            $this->warn("Total brands with invalid category IDs skipped: {$invalidCategoryCount}");
        }

        return 0;
    }
}
