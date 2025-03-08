<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobCategory;

class JobCategorySeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches to optimize performance
        $totalRecords = 100000; // 100K rows

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            JobCategory::factory()->count($batchSize)->create();
        }
    }
}
