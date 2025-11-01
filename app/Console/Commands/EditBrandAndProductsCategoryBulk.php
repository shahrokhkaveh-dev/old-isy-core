<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EditBrandAndProductsCategoryBulk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:edit-brand-and-products-category-bulk
                        {company_id : The ID of the company}
                        {category_id : The new category ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $companyId = $this->argument('company_id');
        $newCategoryId = $this->argument('category_id');

        DB::beginTransaction();
        try {
            $company = Brand::findOrFail($companyId);

            $company->category_id = $newCategoryId;
            $company->save();

            $updatedCount = $company->products()->update([
                'category_id' => $newCategoryId,
                'sub_category_id' => $newCategoryId
            ]);

            DB::commit();

            $this->info("Company and its products updated successfully.");
            $this->info("{$updatedCount} products were updated.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Failed to update: " . $e->getMessage());
        }
    }
}
