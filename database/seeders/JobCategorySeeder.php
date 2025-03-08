<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobCategory;

class JobCategorySeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches to optimize performance
        $totalRecords = 500000; // 500K rows

        // Get the last sort_order from the database
        $lastSortOrder = JobCategory::max('sort_order') ?? 0;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobCategories = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $lastSortOrder++;

                $jobCategories[] = [
                    'name' => 'Category ' . $lastSortOrder, // Unique category name
                    'sort_order' => $lastSortOrder,
                    'created_by' => 1,
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            JobCategory::insert($jobCategories); // Batch insert
            unset($jobCategories); // Free memory
        }
    }
}
